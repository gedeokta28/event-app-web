<?php

namespace Tests\Feature\Http\Controllers\API;

use App\Models\Customer;
use App\Notifications\CustomerResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_register()
    {

        $data = Customer::factory()->make()->toArray();

        $this->postJson(route('api.register'), $data)
            ->assertCreated();

        $this->assertDatabaseHas('customers', [
            'email' => $data['email']
        ]);
    }

    public function test_login()
    {

        $customer = \App\Models\Customer::factory()->create();

        $this->postJson(route('api.login'), [
            'email' => $customer->email,
            'password'  => 'password'
        ])
            ->assertOk()
            ->assertSee('token');
    }

    public function test_logout()
    {

        $customer = \App\Models\Customer::factory()->create();

        Auth::guard('api')->login($customer);

        $this->getJson(route('api.user_profile'))
            ->assertOk()
            ->assertSee($customer->customername);

        $this->postJson(route('api.logout'), [])
            ->assertOk();

        $this->getJson(route('api.user_profile'))
            ->assertStatus(401);
    }

    public function test_refresh_token()
    {

        $customer = \App\Models\Customer::factory()->create();

        Auth::guard('api')->login($customer);

        $this->postJson(route('api.refresh_token'), [])
            ->assertOk();
    }

    public function test_reset_password()
    {
        $customer = \App\Models\Customer::factory()->create();

        Notification::fake();
        $this->postJson(route('api.reset_password'), [
            'email' => $customer->email
        ])
            ->assertOk();

        Notification::assertSentTo($customer, CustomerResetPasswordNotification::class);
    }

    public function test_update_email()
    {
        $customer = \App\Models\Customer::factory()->create();

        $this->loginWithJWT($customer);

        $newEmail = 'updatedemail@mail.com';

        $this->patchJson(route('api.update_profile'), [
            'email' => $newEmail
        ])->assertOk();

        $this->assertDatabaseHas('customers', [
            'customerid' => $customer->customerid,
            'email' => $newEmail
        ]);
    }

    public function test_update_password()
    {
        $customer = \App\Models\Customer::factory()->create();

        $this->loginWithJWT($customer);

        $newPassword = '12345678';
        $passwordConfirmation = '12345678';

        $this->patchJson(route('api.update_profile'), [
            'old_password' => 'password',
            'new_password' => $newPassword,
            'new_password_confirmation' => $passwordConfirmation
        ])->assertOk();

        $currentPassword = $customer->refresh()->password;

        $this->assertTrue(Hash::check($newPassword, $currentPassword));
    }

    public function test_update_bio()
    {
        $customer = \App\Models\Customer::factory()->create();

        $this->loginWithJWT($customer);

        $data = Customer::factory()->make()->toArray();

        $this->patchJson(route('api.update_profile'), $data)->assertOk();
    }

    public function test_update_fcm()
    {
        $customer = \App\Models\Customer::factory()->create();

        $this->loginWithJWT($customer);

        $data = [
            'fcm_token' => $this->faker->uuid()
        ];

        $this->patchJson(route('api.fcm_token'), $data)->assertOk();

        $this->assertDatabaseHas('customers', [
            'customerid' => $customer->customerid,
            'fcm_token' => $data['fcm_token']
        ]);
    }

    public function test_expired_token()
    {
        $customer = \App\Models\Customer::factory()->create();

        $token = $this->loginWithJWT($customer);

        $this->getJson(route('api.user_profile'), [
            'Authorization' => 'Bearer ' . $token
        ])
            ->assertStatus(200);
    }
}
