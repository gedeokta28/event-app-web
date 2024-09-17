<?php

namespace Tests\Feature\Http\Controllers\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_activity_notification_list()
    {

        // make broadcast data

        // get notification table

        $this->get(route('api.notifications.activity'))
            ->assertOk()
            ->assertJsonFragment([
                'data' => [
                    [
                        'description',
                        'image'
                    ]
                ]
            ]);
    }

    public function test_get_transaction_notification_list()
    {
        //
    }
}
