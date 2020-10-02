<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        User::factory()->create([
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
