<?php

namespace App\Http\Controllers;

use App\Models\RentalLine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends ApiController
{
    public function mostRequested(Request $request): JsonResponse
    {
        $data = $request->validate(['from' => ['required', 'date'], 'to' => ['required', 'date', 'after_or_equal:from']]);
        $rows = RentalLine::join('rentals', 'rentals.id', '=', 'rental_lines.rental_id')->whereBetween('rentals.rented_at', [$data['from'].' 00:00:00', $data['to'].' 23:59:59'])->select('rental_lines.bicycle_id', 'rental_lines.model_code', 'rental_lines.bicycle_name', 'rental_lines.category_name', DB::raw('COUNT(*) AS request_count'))->groupBy('rental_lines.bicycle_id', 'rental_lines.model_code', 'rental_lines.bicycle_name', 'rental_lines.category_name')->orderByDesc('request_count')->orderBy('rental_lines.bicycle_name')->get();

        return response()->json($data + ['rows' => $rows]);
    }
}
