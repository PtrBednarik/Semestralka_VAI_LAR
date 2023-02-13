<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;

use App\Http\Controllers\AboutController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\InfoController;

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
    return view('index');
});
//Articles-News
Route::get('/articles', [ArticleController::class,'index'])->name="articles_index";

Route::get('/articles/show/{id}', [ArticleController::class,'show'])->name="article_detail";

Route::get('api/articles', [ArticleController::class,'all']);
Route::post('api/articles', [ArticleController::class,'store']);
Route::put('api/articles/{id}', [ArticleController::class, 'update']);
Route::delete('api/articles/{id}', [ArticleController::class,'destroy']);

//About
Route::get('/about', [AboutController::class, 'index'])->name="about";

//Gallery
Route::get('/gallery', [GalleryController::class, 'index'])->name="gallery";
Route::get('/gallery/{year}', [GalleryController::class, 'show']);
Route::patch('api/gallery/{id}', [GalleryController::class, 'patch'])->name("gallery-patch");

//History
Route::get('/history', [HistoryController::class, 'index'])->name="history";

//Contact
Route::get('/contact', [ContactController::class, 'index'])->name="contact";


//---AUTH

//Info-Posts
Route::get('/info', [InfoController::class,'index'])->name("info_index");
Route::get('/info/show/{id}', [InfoController::class,'show'])->name="info_detail";

Route::get('api/info', [InfoController::class,'all']);
Route::post('api/info', [InfoController::class,'store']);
Route::put('api/info/{id}', [InfoController::class, 'update']);
Route::delete('api/info/{id}', [InfoController::class,'destroy']);

//--ADMIN

Route::get('/users', [UserController::class, 'index'])->name("users_index");
Route::resource('users', UserController::class);
Route::put('/user/{id}', [UserController::class, 'setAsAdmin'])->name('user_setAsAdmin');


//register
Route::get('/register', [RegisterController::class,'index'])->name('user_register');
Route::post('/register', [RegisterController::class,'store'])->name('user_register_post');


//login
Route::get('/login', [LoginController::class,'index'])->name('user_login');
Route::post('/login', [LoginController::class,'login'])->name('user_login_post');

//logout
Route::get('/logout', [LogoutController::class,'logout'])->name('user_logout');

//Auth::routes();
