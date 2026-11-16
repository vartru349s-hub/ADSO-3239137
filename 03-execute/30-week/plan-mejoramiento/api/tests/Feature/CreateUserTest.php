<?php

namespace Tests\Feature;

use Tests\TestCase;

class CreateUserTest extends TestCase
{
    public function test_customer_is_created(): void
    {
        $this->postJson('/api/v1/users', ['name' => 'Sara', 'document_number' => '9911', 'email' => 'sara@example.test'])->assertCreated()->assertJson(['role' => 'customer']);
    }
}
