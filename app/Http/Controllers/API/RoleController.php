<?php

namespace App\Http\Controllers\API;

use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleCollection;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class RoleController extends Controller
{   
    /**
     * List roles
     *
     * @return RoleCollection
     */
    public function index()
    {
        //Select roles distinct name to prevent duplicates due to 
        //multiple guards
        $roles = Role::distinct('name')->get();
        return new RoleCollection($roles);
    }
}
