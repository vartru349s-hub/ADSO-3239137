<?php

namespace Tests\Feature;

use Tests\TestCase;

class UniqueUserDocumentTest extends TestCase
{
    public function test_document_must_be_unique(): void
    {
        $this->customer('9911');
        $this->postJson('/api/v1/users', ['name' => 'Otro', 'document_number' => '9911'])->assertUnprocessable();
    }
}
