<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory; //trait 라고 부름

    protected $fillable = [
        "title",
        "content",
        "user_id",
        "image",
    ];

    public function writer()  {
        // User <-> Post 의 relationship
        // 1:N
        // User는 hasMany posts
        // Post는 belongs to a User
        return $this->belongsTo(User::class, 'user_id');
        /*
            select
            from users u, posts p
            inner join on u.id = p.user_id
        */
    }

    public function likes() {
        // Post -> Post_user -> User
        // N : M
        return $this->belongsToMany(User::class);
    }
}
