<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/test3', function() {
    // 비지니스 로직 처리.. 

    //1. return view('test.show', ['name' => $name, 'age' => 10]);
    //   굳이 변수 안들어가도 됨.
    $name   = '홍길동';
    
    //2. compact('변수명');
    $age    = 20; 
    return view('test.show', compact('name', 'age'));
});
// use 해줘야함 클래스위에 ctrl + i
Route::get('/test4', [TestController::class, 'index']);

//PostsController 에 정의된 function 실행
//create function 실행
Route::get('/posts/create'   ,  [PostsController::class, 'create'])  -> name('posts.create')/* -> middleware(['auth'])*/;

//store function 실행
Route::post('/posts/store'   ,  [PostsController::class, 'store'])   -> name('posts.store')/* -> middleware(['auth'])*/;

//index function 실행
Route::get('/posts/index'    ,  [PostsController::class, 'index'])   -> name('posts.index');

Route::get('/posts/myIndex'  ,  [PostsController::class, 'myIndex']) -> name('posts.myIndex');

//Show 관련
//edit function 실행
Route::get('/posts/show/{id}',  [PostsController::class, 'show'])    -> name('posts.show');

Route::get('/posts/{post}',     [PostsController::class, 'edit'])    -> name('posts.edit');

Route::put('/posts/{id}',       [PostsController::class, 'update'])  -> name('posts.update');

Route::delete('/posts/{id}',    [PostsController::class, 'destroy']) -> name('posts.delete');

// chart
Route::get('/chart/index', [ChartController::class, 'index']) -> name('chart.index');
