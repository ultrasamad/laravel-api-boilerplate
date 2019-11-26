<?php

namespace Tests\Feature;

use Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class LoginUserTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    /**
     *@test
     */
    public function it_logs_in_a_user_if_credentials_provided_are_valid()
    {
        $user = factory('App\Models\User')->create([
            'email' => 'somebody@example.com',
            'password' => bcrypt('super8484'),
        ]);

        $input = [
            'email' => 'somebody@example.com',
            'password' => 'super8484'
        ];
        $response = $this->json('POST', route('auth.login'), $input);
        $response->assertOk();
        $response->assertJsonStructure(['access_token', 'token_type', 'token_expiration', 'user']);
    }
}
