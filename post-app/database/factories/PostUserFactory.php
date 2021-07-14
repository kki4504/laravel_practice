<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostUserFactory extends Factory
{

    protected $users = null;
    protected $posts = null;
    public function __construct()
    {
        parent::__construct();
        $this -> users = User::all();
        $this -> posts = Post::all();
    }

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PostUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        do {
            $userId = $this -> users -> random() -> id;
            $postId = $this -> posts -> random() -> id;
            $postUser = PostUser:: where('user_id', $userId) 
                                -> where('post_id', $postId);
        } while($postUser -> count() != 0);

        return [
            'user_id' => $userId,
            'post_id' => $postId,
            // updated_at 이 없어서 오류가 나는데, 이게 없어도 되도록 명시해줘야 함 -> PostUser.php 에 public $timestamps = false; 

        ];
    }
}
