<?php

namespace Tests\Feature\Http\Controllers\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegionControllerTest extends TestCase
{
    public function test_get_provinces_id()
    {

        $this->getJson(route('api.provinces.id'))
            ->assertOk()
            ->assertSee('Bali');
    }
}
