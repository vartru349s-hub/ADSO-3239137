<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_operator_can_login(): void
    {
        $u = $this->operator();
        $this->postJson('/api/v1/auth/login', ['username' => 'operator', 'password' => 'Operator123!'])->assertOk()->assertJson(['role' => 'operator']);
    }
}
