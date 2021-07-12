<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function imagePath () {
        
        //1.
        // $path = '/storage/images/';

        //2.
        // .env 파일에 IMAGE_PATH 라는 경로 설정
        $path = env('IMAGE_PATH', /* defalt 값 */'/storage/images/');
        
        // 질문
        $imageFile = $this -> image ?? 'no_image_available.png';

        return $path.$imageFile;
    }
    // 내가 연결하고 싶은것 이름
    public function user() {   
        return $this->belongsTo(User::class);

    }
    public function viewers () {
        // return $this->belongsToMany(User::class);   
        return $this -> belongsToMany(User::class, 'post_user', 'post_id', 'user_id', 'id', 'id', 'users');
    }
}
