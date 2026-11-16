<?php

namespace Tests\Feature;

use Tests\TestCase;

class UnavailableBicycleTest extends TestCase
{
    public function test_unavailable_bicycle_returns_conflict(): void
    {
        $this->operator();
        $u = $this->customer();
        $b = $this->bicycle(1);
        $b->update(['available_units' => 0]);
        $this->postJson('/api/v1/rentals', ['user_id' => $u->id, 'bicycle_ids' => [$b->id]])->assertConflict()->assertJson(['code' => 'BICYCLE_NOT_AVAILABLE']);
    }
}
