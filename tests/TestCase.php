<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function apiSignIn($user = null)
    {
        $user = $user ?: User::factory()->create();

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->api_token,
        ]);

        return $this;
    }
}
