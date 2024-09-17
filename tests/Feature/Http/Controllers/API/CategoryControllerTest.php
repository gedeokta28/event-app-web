<?php

namespace Tests\Feature\Http\Controllers\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_category()
    {

        $this->getJson(route('api.categories.index'))
            ->assertOk()
            ->assertJsonCount(10, 'data');
    }

    public function test_show_category()
    {

        $this->getJson(route('api.categories.show', ['category' => 1]))
            ->assertOk()
            ->assertJsonCount(10, 'data');
    }
}
