<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use function GuzzleHttp\Promise\all;

class PostsController extends Controller
{
                    // 생성자 표기는 __construct
    public function __construct()
    {         /* middleware의 auth를 거치기 */    /* 예외 함수 설정 */
        $this -> middleware(['auth']) -> except(['index', 'show']);
    }
    
    public function show(Request $request, $id) {
            $page = $request -> page;
            $post   = Post::find($id);
            $post -> count++;   // 조회수 증가 시킴
            $post -> save();    // DB에 저장

            return view('posts.show', compact('post', 'page'));
    }
    public function edit(Request $request, Post $post) 
    {
        // 수정 폼 생성
        // $post = Post::find($);
        // where 쓰느 방법
        // $post = Post::where('id', $id)->('name', 'kki');
        // return view('posts.edit') -> with('post', $post);
        return view('posts.edit', ['post' => $post, 'page' => $request -> page]);
    }
    public function update(Request $request, $id)
    {
        // 게시글을 데이터베이스에서 수정
        // varidation
        $request -> validate([
            'title'     => 'required|min:3', /*최소 3글자 필요 */
            'content'   => 'required', 
            'imageFile' => 'image | max:1000000'
        ]);
        $post = Post::find($id);
        $page = $request -> page;

        // Authorization. 즉 권한이 있는지 검사
        // 즉, 로그인한 사용자와 게시글의 작성자가 같은지 체크
        // if (auth() -> user() -> id != $post -> user_id) {
        //     abort(403);
        // }
        if ($request -> user() -> cannot('update', $post)) {
            abort (403);
        }
        $post           -> title    = $request -> title;
        $post           -> content  = $request -> content;

        // 이미지 파일 수정. 파일시스템에서
        if($request->file('imageFile')) {
            $imagePath = '/public/images/'.$post -> image;
            Storage::delete($imagePath);
            $post -> image = $this -> uploadPostImage($request);
        }
        $post           -> save();
        
        return redirect() -> route('posts.show', ['id' => $id, 'page' => $page]);
    }
    public function destroy(Request $request, $id) 
    {
        // 파일 시스템에서 이미지 파일 삭제
        // 게시글을 데이터베이스에서 삭제
        $page = $request -> page;
        $post = Post::find($id);

        // Authorization. 즉 권한이 있는지 검사
        // 즉, 로그인한 사용자와 게시글의 작성자가 같은지 체크
        // if (auth() -> user() -> id != $post -> user_id) {
        //     abort(403);
        // }
        if($request -> user() -> cannot('delete', $post)) {
            abort(403);
        }

        if ($post -> image) {
            $imagePath = '/public/images/' . $post -> image;
            Storage::delete($imagePath);
        }
        $post -> delete();
        return redirect() -> route('posts.index', ['page' => $page]);
    }

    public function create() {
        return view('posts.create');
    }

    public function store(Request $request){ 
        // view\create 에서 name 정해준 애들 값 넘어옴
        
        //1번
        // $request -> input['title'];
        // $request -> input['content'];
        
        //2번
        $title          = $request -> title;
        $content        = $request -> content;
        
        // 최소 필요한것들을 요구
        $request -> validate([
            'title'     => 'required|min:3', /*최소 3글자 필요 */
            'content'   => 'required', 
            'imageFile' => 'image | max:1000000'
        ]);
        // dd($request);
        
        // DB저장
        $post = new Post();
        $post           -> title    = $title;
        $post           -> content  = $content;
        $post           -> user_id  = Auth::user() -> id;
        
    
        // File 처리
        // 내가 원하는 파일시스템 상의 위치에 원하는 이름으로 파일을 저장하고,
        if ($request -> file('imageFile')) {
            # code...
            $post -> image = $this->uploadPostImage($request);
        }
        $post -> save();

        // 결과 뷰 반환
        
        return redirect() -> route('posts.index');
    }
    protected function uploadPostImage(Request $request) {
        $name = $request -> file('imageFile') -> getClientOriginalName();
            // $name = 'spaceship.jpg'
    
            $extension = $request -> file('imageFile') -> extension();
            // $extension = 'jpg';
    
            // 사진파일의 앞자리만 떼기
            $nameWithoutExtension = Str::of($name) -> basename('.'.$extension);
            // $nameWithoutExtension = 'spaceship';

            // fileName = 사진이름+_현재시간.extension  
            $fileName = $nameWithoutExtension . '_' .  time() . '.' . $extension;
            // $fileName = 'spaceship_time.jpg;
    
            // 요청된 파일을 resource/storage/app/images 에 저장
            $request -> file('imageFile') -> storeAs('public/images', $fileName);
    
            // 그 파일 이름을 컬럼에 설정
            // $post -> image = $fileName;
            return $fileName;
    }

    public function index() {
        // 1번
        // $posts = Post::orderBy('created_at', 'desc')->get();

        // 2번
        // $posts = Post::latest() -> get();

        // 느린순 1번
        // $posts = Post::orderBy('created_at', 'asc')->get();

        // 2번
        // $posts = Post::oldest() -> get();
        $posts = Post::latest() -> paginate(5); // db에서 받은걸 페이징 하는것

        // dd($posts[0]->created_at);
        return view('posts.index', ['posts' => $posts]);
    }

    public function myIndex(){
        // 교수님 
        // $posts = auth() -> user() -> posts() -> orderBy('title', 'asc') -> orderBy('created_at', 'desc') -> paginate(5);
        $posts = User::find(Auth::user()->id)->posts()->orderBy('title', 'asc')->orderBy('created_at', 'desc')->paginate(5);
 
        return view('posts.myIndex', ['posts' => $posts]);
    }

    // public function viewCount(Request $request) {
    //     $user_id = auth() -> user();
    //     $post_id = $request -> id;

        
    // }
}
