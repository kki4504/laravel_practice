<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Environment\Console;

class CommentsController extends Controller
{
    public function index_test(Post $post) {
        /*
            select * 
            from comments
            where post_id = $post -> id;
        */
        // post 클래스에 comment 함수 구현한 경우
        return $post -> comment;
    }

    public function index($postId) {
        /* 
            select * from comments where post_id = ?
            order by created_at desc;
        */
        $comments = Comment::where('post_id', $postId)->with('user')->get();
        
        return $comments;
    }

    public function update(Request $request, $comment_id) {
        $comment = Comment::find($comment_id);

        $comment -> comment = $request -> comment;
        $comment->save();
        
        return 'update method in Controller is complete';
    }

    public function destroy($comment_id) {
        $comment = Comment::find($comment_id);

        $comment -> delete();
        
        return 'destroy method in Controller is complete';
    }

    public function store($postId, Request $request) {
        
        // 지양함.
        $temp = array_merge(['comment' => $request -> comment], ['user_id' => Auth::user()->id]);
        $temp = array_merge($temp, ['post_id' => $postId]);
        Comment::create($temp);
        // $temp = $request->comment;   
        // // $this->validate($request->comment, ['comment' => 'required']);
        // $comment = new Comment;
        // $comment -> comment = $temp;
        // $comment -> user_id = Auth::user()->id; or user_id = auth()->user()->id 가능
        // $comment -> post_id = $postId;
        // $comment -> save();
        
        return $request->all();
    }

}
