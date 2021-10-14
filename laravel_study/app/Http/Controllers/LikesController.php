<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
{
    /*
        1. 좋아요/좋아요취소 요청을 보낸 로그인된 사용자 정보, 
     */
    public function store(Post $post) {
        // toggle(아이디); -> 있으면 삭제/ 없으면 저장
        return $post -> likes()->toggle(Auth::user());
    }
}
