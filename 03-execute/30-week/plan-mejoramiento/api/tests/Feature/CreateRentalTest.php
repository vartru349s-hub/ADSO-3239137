<?php

namespace Tests\Feature;

use Tests\TestCase;

class CreateRentalTest extends TestCase
{
    public function test_rental_reduces_availability(): void
    {
        $this->operator();
        $u = $this->customer();
        $b = $this->bicycle();
        $this->postJson('/api/v1/rentals', ['user_id' => $u->id, 'bicycle_ids' => [$b->id]])->assertCreated();
        $this->assertDatabaseHas('bicycles', ['id' => $b->id, 'available_units' => 1]);
    }
}
