<?php

namespace Tests;

use App\Models\Bicycle;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use LazilyRefreshDatabase;

    protected function operator(): User
    {
        return User::create(['name' => 'Operador', 'email' => 'operator@example.test', 'username' => 'operator', 'password' => 'Operator123!', 'role' => 'operator']);
    }

    protected function customer(string $document = '1001'): User
    {
        return User::create(['name' => 'Cliente', 'email' => $document.'@example.test', 'document_number' => $document, 'username' => 'customer-'.$document, 'password' => 'Customer123!', 'role' => 'customer']);
    }

    protected function bicycle(int $units = 2): Bicycle
    {
        $category = Category::create(['name' => 'Urbanas']);

        return Bicycle::create(['model_code' => 'BS-001', 'name' => 'Ciudad Uno', 'category_id' => $category->id, 'hourly_rate' => 6000, 'total_units' => $units, 'available_units' => $units]);
    }
}
