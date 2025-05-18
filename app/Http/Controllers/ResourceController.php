<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->input('category', 'ansiedad');
        $resources = Resource::byCategory($category)->get();
        
        return view('resources.index', [
            'resources' => $resources,
            'categories' => ['ansiedad', 'depresión', 'autoestima']
        ]);
    }
}
