<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Configuration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManagementSiteConfigurationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAsSuperadmin();
    }

    public function test_insert_about_us()
    {
        $content = "hello world";

        $this->post(route('about-us.post'), [
            'content' => $content
        ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('configurations', [
            'value' => $content
        ]);
    }

    public function test_update_about_us()
    {

        Configuration::factory([
            'key' => 'aboutus',
            'value' => json_encode('hi')
        ])->create();

        $content = "hello world";

        $this->post(route('about-us.post'), [
            'content' => $content
        ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('configurations', [
            'key'   => 'aboutus',
            'value' => $content
        ]);

        $this->assertDatabaseCount('configurations', 1);
    }
}
