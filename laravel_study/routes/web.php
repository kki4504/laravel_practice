<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\PostsController;
use App\Models\Comment;
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
Route::delete('/posts/images/{id}', [PostsController::class, 'deleteImage'])
                -> middleware(['auth']);
//resource 할때 name 안줘도 됨
Route::resource('/posts', PostsController::class)->middleware(['auth']);

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::post('/like/{post}', 
            [LikesController::class, "store"])
            ->middleware(['auth'])->name('like.store');

Route::get('/posts/comment/index/{postId}', [CommentsController::class, 'index'])  -> name('comment.index');
Route::post('/posts/comment/store/{postId}', [CommentsController::class, 'store']) -> middleware(['auth']) -> name('comment.store');
Route::patch('/posts/comment/update/{comment_id}', [CommentsController::class, 'update']) -> middleware(['auth']) -> name('comment.update');
Route::delete('/posts/comment/delete/{comment_id}', [CommentsController::class, 'destroy']) -> middleware(['auth']) -> name('comment.delete');
require __DIR__.'/auth.php';
