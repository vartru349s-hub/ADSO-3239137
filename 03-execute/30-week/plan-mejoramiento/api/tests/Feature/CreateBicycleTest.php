<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;

class CreateBicycleTest extends TestCase
{
    public function test_bicycle_is_created_with_available_units(): void
    {
        $c = Category::create(['name' => 'Urbanas']);
        $this->postJson('/api/v1/bicycles', ['model_code' => 'URB-1', 'name' => 'Urbana', 'category_id' => $c->id, 'hourly_rate' => 5000, 'total_units' => 4])->assertCreated()->assertJson(['available_units' => 4]);
    }
}
