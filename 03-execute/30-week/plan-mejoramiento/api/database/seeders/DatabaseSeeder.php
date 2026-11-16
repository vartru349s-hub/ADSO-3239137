<?php

namespace Database\Seeders;

use App\Models\Bicycle;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['username' => 'operator'], ['name' => 'Operador principal', 'email' => 'operator@bike-share.local', 'password' => 'Operator123!', 'role' => 'operator']);
        User::updateOrCreate(['document_number' => '1001001001'], ['name' => 'Ana Torres', 'email' => 'ana@example.test', 'username' => 'customer-1001001001', 'password' => 'Customer123!', 'role' => 'customer']);
        foreach (['Urbanas', 'Montaña', 'Plegables', 'Eléctricas', 'Infantiles'] as $index => $name) {
            $category = Category::firstOrCreate(['name' => $name]);
            Bicycle::updateOrCreate(['model_code' => 'BS-'.str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT)], ['name' => 'Bicicleta '.$name, 'category_id' => $category->id, 'hourly_rate' => 6000 + $index * 1000, 'total_units' => 3, 'available_units' => 3]);
        }
    }
}
