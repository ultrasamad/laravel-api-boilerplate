<?php

namespace Tests;

use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Custom
    */
    public function authenticate($user = null)
    {
        $user = $user ?? factory('App\Models\User')->create();
        Passport::actingAs($user);
        return $this;
    }
}
