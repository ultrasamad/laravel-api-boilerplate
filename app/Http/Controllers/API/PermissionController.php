<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\PermissionCollection;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class PermissionController extends Controller
{
    
    /**
     * List all permissions
     *
     * @param Request $request
     * @return PermissionCollection
     */
    public function index(Request $request)
    {
        return new PermissionCollection(
            Permission::distinct('name')->get()
        );
    }
}
