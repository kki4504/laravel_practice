<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('bbs.index', ['posts' => $posts]);
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
        
        // Post::crate($input);
        // $post = new Post;
        // $post -> title = $input['title'];
        // $post -> content = $input['content'];
        // ...
        // $post -> save();
        return redirect()->route('posts.index');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
