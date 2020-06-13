<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    public function __invoke(Request $request)
    {
        $menus = [
            [
                'name' => 'Auth',
                'page' => 'auth',
                'children' => [
                    ['method' => 'POST', 'title' => 'Login', 'page' => 'login'],
                    ['method' => 'POST', 'title' => 'Register', 'page' => 'register'],
                    ['method' => 'POST', 'title' => 'Logout', 'page' => 'logout'],
                ]
            ],
        ];

        $page = $request->query('page') ?? 'welcome';        
        return view('docs.pages.'.$page, compact('menus'));
    }
}
