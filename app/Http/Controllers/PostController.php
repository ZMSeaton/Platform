<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }

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
        return view('feed', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $request['user_id'] = Auth::user()->id;
        Post::create($request->all());
        return redirect(route('posts.index'))->with('status', 'Post made!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $user = $post->user()->first();
        return view('post.detail', ['user' => $user, 'post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('post.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->all());
        return redirect(route('posts.show', ['post' => $post]))->with('status', 'Post updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect(route('posts.index'))->with('status', 'Post deleted!');
    }
}
