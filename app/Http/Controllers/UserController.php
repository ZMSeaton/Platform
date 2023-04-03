<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display users.
     */
    public function index()
    {
        $users = User::all();
        return view('user.list', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        redirect('auth.register');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $posts = $user->posts;
        return view('user.detail', ['user' => $user, 'posts' => $posts]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('user.update', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $img = $request->file('image');

        $img_name = time().'.'.$img->getClientOriginalExtension();

        Image::make($img)->resize(150, 150, function ($constraint){
            $constraint->aspectRatio();
        })->save(public_path('img/profile').'/'.$img_name);

        $user->update(['image' => $img_name]);

        return redirect(route('home'))->with('status', 'Icon updated!');

    }

    public function follow(Request $request, User $user){
        
        if (Auth::user()->isFollowing($user)){
            DB::table('follows')->where('follower', '=', Auth::user()->id)->where('followed', '=', $user->id)->delete();
            return redirect(route('users.show', ['user' => $user]))->with('status', 'Now unfollowed!');
        } else {
            DB::table('follows')->insert([ 'follower' => Auth::user()->id, 'followed' => $user->id ]);
            return redirect(route('users.show', ['user' => $user]))->with('status', 'Now following!');
        }

    }

}
