<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\PermissionCollection;

class PermissionController extends Controller
{
    
    /**
     * List all permissions
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        return new PermissionCollection(
            Permission::distinct('name')->get()
        );
    }
}
