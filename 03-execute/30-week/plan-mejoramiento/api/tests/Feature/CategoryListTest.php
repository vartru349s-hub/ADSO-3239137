<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;

class CategoryListTest extends TestCase
{
    public function test_categories_are_listed(): void
    {
        Category::create(['name' => 'Urbanas']);
        $this->getJson('/api/v1/categories')->assertOk()->assertJsonFragment(['name' => 'Urbanas']);
    }
}
