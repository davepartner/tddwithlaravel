<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
class PostController extends Controller
{
    //

    public function store(){
        request()->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string'
        ]);
        
        $post = Post::create([
            'title' => request('title'),
            'body' => request('body')
        ]);

        return request()->wantsJson() ? response()->json($post, 201) : null;
    }
}
