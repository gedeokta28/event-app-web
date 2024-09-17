<?php

namespace Tests\Feature\Http\Controllers\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BannerControllerTest extends TestCase
{

    use RefreshDatabase;

    public function test_get_banner_list()
    {

        $this->getJson(route('api.banners.index'))
            ->assertOk()
            ->assertJsonCount(10, 'data');
    }
}
