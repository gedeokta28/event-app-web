<?php

namespace Tests;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Auth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function actingAsAdmin()
    {
        $user = User::factory([
            'role' => User::ADMIN
        ])->create();

        return $this->actingAs($user, 'web');
    }

    protected function actingAsSuperadmin()
    {
        $user = User::factory([
            'role' => User::SUPERADMIN
        ])->create();

        return $this->actingAs($user, 'web');
    }

    protected function loginWithJWT(Authenticatable $user)
    {
        return Auth::guard('api')->login($user);
    }
}
