<?php

namespace Tests\Feature;

use Tests\TestCase;

class InvalidLoginTest extends TestCase
{
    public function test_invalid_login_is_rejected(): void
    {
        $this->postJson('/api/v1/auth/login', ['username' => 'none', 'password' => 'bad'])->assertUnauthorized();
    }
}
