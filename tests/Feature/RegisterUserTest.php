<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterUserTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    /**
     * @test
     */
    public function it_registers_a_user_provided_details_are_valid()
    {
        $input = [
            'name' => 'Mr somebody',
            'email' => 'somebody@example.com',
            'password' => 'supersecret77',
            'password_confirmation' => 'supersecret77'
        ];
        $response = $this->json('POST', route('auth.register'), $input);
        $response->assertOk();
        $response->assertJsonStructure(['access_token', 'token_type', 'token_expiration', 'user']);
    }
}
