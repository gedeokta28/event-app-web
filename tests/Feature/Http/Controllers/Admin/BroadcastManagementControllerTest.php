<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class BroadcastManagementControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_list_broadcast()
    {
        $this->get(route('brodcasts.index'))->assertOk();
    }

    public function test_create_form_broadcast()
    {
        $this->get(route('broadcasts.create'))
            ->assertOk()
            ->assertSee('description')
            ->assertSee('image');
    }

    public function test_store_broadcast_to_database()
    {

        $this->post(route('broadcasts.store'), [
            'description' => 'hello world',
            'image' => UploadedFile::fake()->file('testing.jpg')
        ])
            ->assertRedirect(route('broadcasts.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseCount('broadcasts', 1);

        $this->assertDatabaseHas('broadcasts', [
            'description' => 'hello world'
        ]);
    }

    public function test_edit_broadcast()
    {

        $brodcast = \App\Models\Broadcast::factory()->create();

        $this->get(route('broadcasts.edit', ['broadcast' => $brodcast->id]))
            ->assertOk()
            ->assertSee($brodcast->descrption);
    }

    public function test_update_broadcast()
    {
        $brodcast = \App\Models\Broadcast::factory()->create();

        $this->put(route('broadcasts.update', ['broadcast' => $brodcast->id]), [
            'description' => 'hello world',
            'image_path' => UploadedFile::fake()->image('testing.jpg')
        ])
            ->assertOk()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('broadcast', [
            'description' => 'hello world'
        ]);
    }

    public function test_delete_broadcast()
    {
        $brodcast = \App\Models\Broadcast::factory()->create();

        $this->delete(route('broadcasts.destroy', [
            'broadcast' => $brodcast->id
        ]))->assertOk();

        $this->assertSoftDeleted('broadcasts', [
            'id' => $brodcast->id
        ]);
    }
}
