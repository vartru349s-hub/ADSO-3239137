<?php

namespace Tests\Feature;

use Tests\TestCase;

class ReturnBicycleTest extends TestCase
{
    public function test_return_restores_availability(): void
    {
        $this->operator();
        $u = $this->customer();
        $b = $this->bicycle(1);
        $r = $this->postJson('/api/v1/rentals', ['user_id' => $u->id, 'bicycle_ids' => [$b->id]])->json();
        $this->postJson('/api/v1/rentals/'.$r['id'].'/lines/'.$r['lines'][0]['id'].'/return')->assertOk();
        $this->assertDatabaseHas('bicycles', ['id' => $b->id, 'available_units' => 1]);
    }
}
