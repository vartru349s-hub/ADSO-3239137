<?php

namespace Tests\Feature;

use Tests\TestCase;

class ListBicyclesTest extends TestCase
{
    public function test_bicycles_are_listed(): void
    {
        $this->bicycle();
        $this->getJson('/api/v1/bicycles')->assertOk()->assertJsonPath('data.0.model_code', 'BS-001');
    }
}
