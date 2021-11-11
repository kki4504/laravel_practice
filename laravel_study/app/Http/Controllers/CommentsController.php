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
      
        $comments = Comment::where('post_id', $postId)->with('user')->latest()->paginate(5);
        
        return $comments;
    }

    public function update(Request $request, $comment_id) {
        $comment = Comment::find($comment_id);

        $this->authorize('update', $comment);
        
        $comment -> comment = $request -> comment;
        $comment->save();
        
        return 'update method in Controller is complete';
    }

    public function destroy(Request $request, $comment_id) {
        /*
            comments 테이블에서 id가 $commentId인 레코드를 삭제
            1. RAW query
            2. DB Query Builder
            3. Eloquent
        */
        $comment = Comment::find($comment_id);

        // CommentPolicy를 적용한 권한관리를 하자.
        // 즉 이 요청을 한 사용자가 이 댓글을 삭제할 수 있는지 체크하자.
        // $this-> authorize('delete', $comment); 
        if($request -> user() -> can('delete', $comment)) { 
            $comment -> delete();

            return 'destroy method in Controller is complete';
            
        } else { // 삭제 권한이 없는 경우
            abort(403);
        }
        
        
    }

    public function store($postId, Request $request) {
        /* 첫 번째 방법: 
            comment 객체를 생성하고,
            이 객체의 멤버변수 (프로퍼티) 를 설정하고
            save();

            두번째 방법 :
            comment::create([]);

            validation check
        */
        // 지양함.
        $temp = array_merge(['comment' => $request -> comment], ['user_id' => auth()->user()->id]);
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
