<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*
            1. 게시글 리스트를 DB에서 읽어와야지
            2. 게시글 목록 만들어주는 blade 에 읽어온 데이터를 전달하고 실행
        */
        // select * from posts order by created_at desc
        // $posts = Post::latest()->get();
        // $posts = Post::oldest()->get();
        // $posts = Post::orderBy('created_at', 'desc')->get();
        
        $posts = Post::latest()->paginate(10);
        // dd($posts);
        

        return view ('bbs.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create()
    {
        return view('bbs.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
    

        $this->validate($request, ['title'=>'required', 'content'=>'required|min:3']);
        
        $path = null;
        $fileName = null;

        if($request->hasFile('image')) {
            $fileName =  time().'_'.$request->file('image')->getClientOriginalName();

            $path = $request->file('image')->storeAs('public/images', $fileName);
        }

        $input = array_merge($request->all(), ["user_id" => Auth::user()->id]);
        // 이미지가 있으면 .. $input 
        if($fileName) {
            
            $input = array_merge($input, ["image" => $fileName ]);
        }
        // $input ["title"=> "suifwe", "content"=> "sfuiowejf", "user_id"=> 1]
        // redirect 안하면 F5 시 계속 같은 값이 넘어감
        // mass assignment
        // Eloquent model의 white list 인  $fillable 에 기술해야 한다.
        Post::create($input);
        
        // Post::create($input);
        // $post = new Post;
        // $post -> title = $input['title'];
        // $post -> content = $input['content'];
        // ...
        // $post -> save();
        return redirect()->route('posts.index')->with('success', 1);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $id에 해당하는 Post를 데이터베이스에서 인출
        // eager loading (즉시로딩)
        $post = Post::with('likes')->find($id);
        // 그 놈을 상세보기 뷰로 전달한다.
        return view('bbs.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // 의존성 주입
        // DI(Dependency Injection)

        // $id에 해당하는 포스트를 수정할 수 있는
        // 페이지를 반환해주면 된다.
        $post = Post::find($id);

        $this->authorize('update', $post);

        return view('bbs.edit', ['post' => Post::find($id)]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, ['title'=>'required', 'content'=>'required|min:3']);

        $post = Post::find($id);
        // $post -> title = $request   -> input['title'];
        $post -> title   = $request -> title;
        $post -> content = $request -> content;

        $fileName = null;

        if($request->image) {
            // 이 이미지를 이 게시글의 이미지로 파일시스템에
            // 저장하고, DB에 반영하기 전에
            // 기존 이미지가 있다면
            // 그 이미지를 파일 시스템에서 삭제해줘야 한다.
            if($post -> image) {
                Storage::delete('public/images/'.$post->image); 
                
            }
            $fileName =  time().'_'.$request->file('image')->getClientOriginalName();

            $post -> image = $fileName;
            $request->file('image')->storeAs('public/images', $fileName);

        }
        $post -> save();

        // $input = array_merge($request->all(), ["user_id" => Auth::user()->id]);
        // // 이미지가 있으면 .. $input 
        // if($fileName) {
            
        //     $input = array_merge($input, ["image" => $fileName ]);
        // }

        // $post = Post::find($id);
        
        // 1.
        // $post->title = $request->title;
        // $post->content = $request->content;

        // $post->save();

        // $post->update(['title' => $request->title, 
                        // 'content' => $request->content]);
            
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // DI를 항상 먼저 써야함 
    public function destroy(Request $request, $id)
    {
        // DI, Dependency Injection, 의존성 주입
        $post = Post::find($id);

        // 게시글에 딸린 이미지가 있으면 파일시스템에서도 삭제해줘야 한다.
        if($post -> image) {
            Storage::delete('public/images/'.$post->image);
        }
        
        $post -> delete();

        return redirect()->route('posts.index');
    }
    public function deleteImage($id) {
        $post = Post::find($id);
        $this->authorize('delete', $post);
        if($post -> image) {
            Storage::delete('public/image/'.$post->image);
            $post->image = null;
            $post->save();
        }
        return redirect()->route('posts.edit', ['post'=>$post->id]);
    }
    public function myIndex() {
        $user_id = auth()->user()->id;
        $posts = Post::where('user_id', $user_id)->latest()->paginate(10);
        // dd($posts);
        // $posts = Post::latest()->paginate(10);
        
        return view('bbs.myIndex', ['posts' => $posts]);
    }
}
