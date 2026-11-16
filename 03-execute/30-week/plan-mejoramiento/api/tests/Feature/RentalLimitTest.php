<?php

namespace Tests\Feature;

use Tests\TestCase;

class RentalLimitTest extends TestCase
{
    public function test_more_than_two_bicycles_is_rejected(): void
    {
        $this->operator();
        $u = $this->customer();
        $this->postJson('/api/v1/rentals', ['user_id' => $u->id, 'bicycle_ids' => ['a', 'b', 'c']])->assertUnprocessable();
    }
}
