<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class LogoutUserTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     *@test
     */
    public function it_logs_out_an_authenticated_user()
    {
        $user = User::factory()->create();
        $this->authenticate($user);

        $response = $this->getJson(route('auth.logout'));
        $response->assertOk();
    }
}
