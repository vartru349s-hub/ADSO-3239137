<?php

namespace Tests\Feature;

use Tests\TestCase;

class UpdateBicycleTest extends TestCase
{
    public function test_bicycle_can_be_updated(): void
    {
        $b = $this->bicycle();
        $this->putJson('/api/v1/bicycles/'.$b->id, ['model_code' => 'BS-001', 'name' => 'Ciudad Dos', 'category_id' => $b->category_id, 'hourly_rate' => 7000, 'total_units' => 3])->assertOk()->assertJson(['name' => 'Ciudad Dos']);
    }
}
