<?php

namespace Tests\Feature;

use Tests\TestCase;

class SoftDeleteBicycleTest extends TestCase
{
    public function test_catalog_uses_soft_delete(): void
    {
        $b = $this->bicycle();
        $this->deleteJson('/api/v1/bicycles/'.$b->id)->assertNoContent();
        $this->assertSoftDeleted('bicycles', ['id' => $b->id]);
    }
}
