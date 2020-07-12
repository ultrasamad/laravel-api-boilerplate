<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Http\Resources\RoleCollection;

class RoleController extends Controller
{   
    /**
     * List roles
     *
     * @return void
     */
    public function index()
    {
        //Select roles distinct name to prevent duplicates due to 
        //multiple guards
        $roles = Role::distinct('name')->get();
        return new RoleCollection($roles);
    }
}
