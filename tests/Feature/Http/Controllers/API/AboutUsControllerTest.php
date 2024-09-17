<?php

namespace Tests\Feature\Http\Controllers\API;

use App\Models\Configuration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AboutUsControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAsSuperadmin();
    }

    public function test_get_aboutus_api()
    {
        $config = Configuration::factory([
            'key' => 'aboutus',
            'value' => json_encode($this->faker()->paragraph())
        ])->create();

        $this->getJson(route('api.aboutus'))
            ->assertOk()
            ->assertSee(json_decode($config->value));
    }
}
