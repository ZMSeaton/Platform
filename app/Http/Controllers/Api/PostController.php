<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $following = Auth::user()->following;
        $posts = array();
        foreach ($following as $follow) {
            foreach ($follow->posts as $post){
                array_push($posts, $post);
            } 
        }
        //$posts = DB::table('posts')->join('users', 'users.id', '=', 'posts.user_id')->join('follows', 'users.id', '=', 'follows.followed')->where('follower', '=', Auth::user()->id);
        return $posts;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $request['user_id'] = Auth::user()->id;
        Post::create($request->all());
        return response()->json([
            "message" => "post made"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->all());
        return response()->json([
            "message" => "post updated"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            "message" => "post removed"
        ], 202);
    }
}
