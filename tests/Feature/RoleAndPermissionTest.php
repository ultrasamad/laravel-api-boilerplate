<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleAndPermissionTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * Setup
     *
     * @return void
     */
    public function setUp():void
    {
        parent::setUp();
        $this->seed('RoleAndPermissionSeeder');
        $this->admin = $this->authenticate();
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_lists_all_roles_in_the_system()
    {
        $response = $this->getJson(route('roles.index'));
        $response->assertOk();
        $response->assertJsonCount(2, 'data');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_lists_all_permissions_in_the_system()
    {
        $response = $this->getJson(route('permissions.index'));
        $response->assertOk();
        $response->assertJsonCount(5, 'data');
    }

    /**
     * @test
     *
     * @return void
     */
    public function an_authorized_admin_can_update_roles_list_of_a_user()
    {
        $this->admin->givePermissionTo('Update user roles');
        
        $user = factory('App\Models\User')->create();
        //Assert user has no admin role yet
        $this->assertFalse($user->hasRole('Admin'));
        $input = [
            'roles' => ['Admin']
        ];
        $response = $this->patchJson(route('user.roles.update', $user), $input);
        $response->assertOk();
        //Assert user now has Admin role
        $this->assertTrue($user->fresh()->hasRole('Admin'));
        $response->assertJson([
            'data' => [
                'message' => 'User roles list updated successfully'
            ]
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function an_authorized_admin_can_update_permissions_list_of_a_user()
    {
        $this->admin->givePermissionTo('Update user roles');

        $user = factory('App\Models\User')->create();
        //Assert user has no admin role yet
        $this->assertFalse($user->hasPermissionTo('Create user', 'api'));
        $input = [
            'permissions' => ['Create user']
        ];
        $response = $this->patchJson(route('user.permissions.update', $user), $input);
        $response->assertOk();
        //Assert user now has Admin role
        $this->assertTrue($user->fresh()->hasPermissionTo('Create user', 'api'));
        $response->assertJson([
            'data' => [
                'message' => 'User permissions list updated successfully'
            ]
        ]);
    }
}
