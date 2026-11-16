<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = User::query()->where('role', 'customer');
        if ($search = $request->string('q')->trim()->toString()) {
            $query->where(fn ($q) => $q->where('name', 'like', "%$search%")->orWhere('document_number', 'like', "%$search%"));
        }

        return response()->json($query->orderBy('name')->paginate(min(max($request->integer('size', 20), 1), 50)));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:160'], 'document_number' => ['required', 'string', 'max:30', 'unique:users'], 'email' => ['nullable', 'email', 'unique:users']]);
        $user = User::create($data + ['username' => 'customer-'.strtolower($data['document_number']), 'password' => 'Customer123!', 'role' => 'customer']);

        return response()->json($user, 201);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:160'], 'email' => ['nullable', 'email', 'unique:users,email,'.$user->id]]);
        $user->update($data);

        return response()->json($user->fresh());
    }
}
