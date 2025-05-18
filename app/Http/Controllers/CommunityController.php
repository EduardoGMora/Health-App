<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('community.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:100',
            'body' => 'required',
            'category' => 'required'
        ]);

        Post::create([
            'user_id' => Auth::id(),
            'username' => $request->anonymous ? 'Anónimo' : Auth::user()->name,
            'title' => $request->title,
            'body' => $request->body,
            'category' => $request->category
        ]);

        return back()->with('success', 'Post publicado!');
    }
}
