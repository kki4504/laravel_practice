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
}
