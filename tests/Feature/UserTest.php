<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * @test
     */
    public function an_authenticated_user_can_list_all_users()
    {
        $this->authenticate();
        factory(User::class, 2)->create();
        $response = $this->json('GET', route('users.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'data', 'pagination'
        ]);
        $response->assertJsonCount(3, 'data'); // 3 => 2 + the authenticated user which is created in TestCase.
    }

    /**
     * @test
    */
    public function an_authenticated_user_can_show_details_of_a_specific_user()
    {
        $this->authenticate();
        $user = factory(User::class)->create();
        $response = $this->json('GET', route('users.show', $user));
        $response->assertOk();
        $response->assertJson([
            'data'  => [
                'name'  => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    /**
     * @test
    */
    public function an_authorized_user_can_create_a_new_user()
    {
        $this->authenticate();
        $input = [
            'name'  => $this->faker->name,
            'email' => $this->faker->email,
            'password'  => 'secretABC',
            'password_confirmation' => 'secretABC'
        ];

        $response = $this->json('POST', route('users.store'), $input);
        $this->assertDatabaseHas('users', [
            'name'  => $input['name'],
        ]);
        $response->assertStatus(201);
        $response->assertJson([
            'data'  => [
                'name'  => $input['name']
            ],
        ]);
    }

    /**
     * @test
    */
    public function an_authorized_user_can_update_a_user_details()
    {
        $this->authenticate();
        $user = factory(User::class)->create();
        $input = [
            'name'  => 'Mr Nobody',
        ];

        $response = $this->json('PATCH', route('users.update', $user), $input);
        $this->assertDatabaseHas('users', [
            'name'  => 'Mr Nobody',
        ]);
        $response->assertOk();
        $response->assertJson([
            'data'  => [
                'name'  => $input['name']
            ],
        ]);
    }

    /**
     * @test
    */
    public function an_authorized_user_can_soft_delete_a_user()
    {
        $this->authenticate();
        $user = factory(User::class)->create();
        $response = $this->json('DELETE', route('users.destroy', $user));
        $response->assertStatus(204);
        $this->assertSoftDeleted('users', [
            'name'  => $user->name,
        ]);
    }

    /**
     * @test
    */
    public function a_name_is_required_to_create_a_new_user()
    {
        $this->authenticate();
        $input = [
            'email' => $this->faker->email,
            'password'  => 'supersecret',
            'password_confirmation' => 'supersecret'
        ];
        $response = $this->json('POST', route('users.store'), $input);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'name'  => 'The name field is required.'
        ]);
    }

    /**
     * @test
    */
    public function an_email_is_required_to_create_a_new_user()
    {
        $this->authenticate();
        $input = [
            'name' => $this->faker->name,
            'password'  => 'supersecret',
            'password_confirmation' => 'supersecret'
        ];
        $response = $this->json('POST', route('users.store'), $input);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email'  => 'The email field is required.'
        ]);
    }
}
