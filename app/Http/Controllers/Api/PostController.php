<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostsResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // /*if ($request->input('page')){
        //     $posts = Auth::user()->feed;
        //     return new PostsResource($posts);
        // }*/

        // $following = Auth::user()->following;
        // $posts = array();
        // foreach ($following as $follow) {
        //     foreach ($follow->posts as $post){
        //         array_push($posts, $post);
        //     } 
        // }

        // if ($request->input('sort')){
            
        // }

        // //$posts = DB::table('posts')->join('users', 'users.id', '=', 'posts.user_id')->join('follows', 'users.id', '=', 'follows.followed')->where('follower', '=', Auth::user()->id);
        // return new PostsResource($posts->paginate(4));

        $following_ids = Auth::user()->following()->pluck('id');
        $posts = Post::whereIn('user_id', $following_ids)->with('user')->paginate(4);
        return new PostsResource($posts);
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
        return new PostResource($post);
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
