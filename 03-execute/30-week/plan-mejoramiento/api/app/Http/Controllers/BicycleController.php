<?php

namespace App\Http\Controllers;

use App\Models\Bicycle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BicycleController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = Bicycle::with('category');
        if ($search = $request->string('q')->trim()->toString()) {
            $query->where(fn ($q) => $q->where('model_code', 'like', "%$search%")->orWhere('name', 'like', "%$search%"));
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        return response()->json($query->orderBy('name')->paginate(min(max($request->integer('size', 20), 1), 50)));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());
        $data['available_units'] = $data['total_units'];

        return response()->json(Bicycle::create($data)->load('category'), 201);
    }

    public function show(Bicycle $bicycle): JsonResponse
    {
        return response()->json($bicycle->load('category'));
    }

    public function update(Request $request, Bicycle $bicycle): JsonResponse
    {
        $data = $request->validate($this->rules($bicycle->id));
        $rented = $bicycle->total_units - $bicycle->available_units;
        if ($data['total_units'] < $rented) {
            return $this->error('UNITS_IN_USE', 'El total no puede ser menor que las unidades alquiladas.', 422);
        }
        $data['available_units'] = $data['total_units'] - $rented;
        $bicycle->update($data);

        return response()->json($bicycle->fresh()->load('category'));
    }

    public function destroy(Bicycle $bicycle): JsonResponse
    {
        if ($bicycle->rentalLines()->whereNull('returned_at')->exists()) {
            return $this->error('BICYCLE_HAS_OPEN_RENTALS', 'La bicicleta tiene alquileres abiertos.', 409);
        } $bicycle->delete();

        return response()->json(null, 204);
    }

    private function rules(?string $id = null): array
    {
        return ['model_code' => ['required', 'string', 'max:40', 'unique:bicycles,model_code'.($id ? ",$id" : '')], 'name' => ['required', 'string', 'max:160'], 'category_id' => ['required', 'uuid', 'exists:categories,id'], 'hourly_rate' => ['required', 'numeric', 'min:0'], 'total_units' => ['required', 'integer', 'min:1']];
    }
}
