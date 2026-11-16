<?php

namespace App\Http\Controllers;

use App\Models\Bicycle;
use App\Models\Rental;
use App\Models\RentalLine;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RentalController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        return response()->json(Rental::with('lines')->latest('rented_at')->paginate(min(max($request->integer('size', 20), 1), 50)));
    }

    public function show(Rental $rental): JsonResponse
    {
        return response()->json($rental->load('lines'));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate(['user_id' => ['required', 'integer', 'exists:users,id'], 'bicycle_ids' => ['required', 'array', 'min:1', 'max:2'], 'bicycle_ids.*' => ['required', 'uuid', 'distinct', 'exists:bicycles,id']]);
        $customer = User::findOrFail($data['user_id']);
        $open = RentalLine::whereHas('rental', fn ($q) => $q->where('user_id', $customer->id))->whereNull('returned_at');
        if ((clone $open)->where('due_at', '<', now())->exists()) {
            return $this->error('USER_HAS_OVERDUE_RENTALS', 'El usuario tiene alquileres vencidos.', 409);
        }
        if ($open->count() + count($data['bicycle_ids']) > 2) {
            return $this->error('USER_RENTAL_LIMIT', 'El usuario no puede tener más de dos bicicletas sin devolver.', 409);
        }

        return DB::transaction(function () use ($data, $customer) {
            $bicycles = Bicycle::whereIn('id', $data['bicycle_ids'])->lockForUpdate()->get()->keyBy('id');
            foreach ($data['bicycle_ids'] as $id) {
                if (($bicycles[$id]->available_units ?? 0) < 1) {
                    return $this->error('BICYCLE_NOT_AVAILABLE', 'No quedan unidades disponibles.', 409);
                }
            }
            $operator = User::where('role', 'operator')->firstOrFail();
            $rental = Rental::create(['id' => (string) Str::uuid(), 'user_id' => $customer->id, 'operator_id' => $operator->id, 'rented_at' => now()]);
            foreach ($bicycles as $bicycle) {
                $bicycle->decrement('available_units');
                RentalLine::create(['id' => (string) Str::uuid(), 'rental_id' => $rental->id, 'bicycle_id' => $bicycle->id, 'model_code' => $bicycle->model_code, 'bicycle_name' => $bicycle->name, 'category_name' => $bicycle->category->name, 'hourly_rate' => $bicycle->hourly_rate, 'due_at' => now()->addDay()]);
            }

            return response()->json($rental->load('lines'), 201);
        }, 3);
    }

    public function returnLine(Rental $rental, RentalLine $line): JsonResponse
    {
        if ($line->rental_id !== $rental->id) {
            return $this->error('NOT_FOUND', 'Línea de alquiler no encontrada.', 404);
        }if ($line->returned_at) {
            return $this->error('LINE_ALREADY_RETURNED', 'La bicicleta ya fue devuelta.', 409);
        }DB::transaction(function () use ($line) {
            $line->update(['returned_at' => now()]);
            Bicycle::withTrashed()->findOrFail($line->bicycle_id)->increment('available_units');
        });

        return response()->json($line->fresh());
    }

    public function overdue(): JsonResponse
    {
        return response()->json(['items' => RentalLine::with('rental.user')->whereNull('returned_at')->where('due_at', '<', now())->orderBy('due_at')->get()]);
    }
}
