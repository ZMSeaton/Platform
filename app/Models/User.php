<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'follower', 'followed');
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'followed', 'follower');
    }

    public function isFollowing(User $user)
    {
        return !! $this->following()->where('followed', $user->id)->count();
    }

    public function isFollowedBy(User $user)
    {
        return !! $this->following()->where('followed', $user->id)->count();
    }

    public function feed()
    {
        // $following = $this->following();
        // $posts = array();
        // foreach ($following as $follow) {
        //     foreach ($follow->posts as $post){
        //         array_push($posts, $post);
        //     } 
        // }
        // return $posts;

        // get ids of the users I'm following
        $following_ids = $this->following()->pluck('id');
        
        // get posts from those users (we'll alter this in the future)
        $posts = Post::whereIn('user_id', $following_ids)->with('user')->latest()->limit(10)->get();

        return $posts;
    }

}
