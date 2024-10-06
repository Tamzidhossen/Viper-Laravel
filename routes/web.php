<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Frontend
Route::get('/',[FrontendController::class, 'index'])->name('index');
Route::get('/author/login/page', [FrontendController::class, 'author_login_page'])->name('author.login.page');
Route::get('/author/Register/page', [FrontendController::class, 'author_register_page'])->name('author.register.page');

require __DIR__.'/auth.php';

//Backend
Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Profile
Route::post('/add/user', [UserController::class, 'add_user'])->middleware('auth')->middleware('auth')->name('add.user');
Route::get('/users', [UserController::class, 'users'])->name('users');
Route::get('/edit/profile', [UserController::class, 'edit_profile'])->middleware('auth')->name('edit.profile');
Route::post('/update/profile', [UserController::class, 'update_profile'])->name('update.profile');
Route::post('/update/password', [UserController::class, 'update_password'])->name('update.password');
Route::post('/update/photo', [UserController::class, 'update_photo'])->name('update.photo');
Route::get('/user/delete/{user_id}', [UserController::class, 'user_delete'])->name('user.delete');

//Category
Route::get('/category', [CategoryController::class, 'category'])->middleware('auth')->name('category');
Route::get('/category/trash', [CategoryController::class, 'trash'])->middleware('auth')->name('trash');
Route::post('/category/store', [CategoryController::class, 'category_store'])->name('category.store');
Route::get('/category/edit/{category_id}', [CategoryController::class, 'category_edit'])->middleware('auth')->name('category.edit');
Route::post('/category/update/{category_id}', [CategoryController::class, 'category_update'])->name('category.update');
Route::get('/category/delete/{category_id}', [CategoryController::class, 'category_delete'])->name('category.delete');
Route::get('/category/restore/{category_id}', [CategoryController::class, 'category_restore'])->name('category.restore');
Route::get('/category/hard_delete/{category_id}', [CategoryController::class, 'category_hard_delete'])->name('category.hard.delete');
Route::post('/category/check_delete', [CategoryController::class, 'category_check_delete'])->name('category.check.delete');
Route::post('/category/check/restore', [CategoryController::class, 'category_check_restore'])->name('category.check.restore');


//Tags
Route::get('/tags', [TagController::class, 'tags'])->name('tags');
Route::post('/tag/store', [TagController::class, 'tags_store'])->name('tags.store');
Route::get('/tag/delete/{tag_id}', [TagController::class, 'tags_delete'])->name('tags.delete');

//Authors
Route::post('/author/register/post', [AuthorController::class, 'author_register'])->name('author.register');
Route::post('/author/login/post', [AuthorController::class, 'author_login'])->name('author.login');
Route::get('/author/logout', [AuthorController::class, 'author_logout'])->name('author.logout');
Route::get('/author/dashboard', [AuthorController::class, 'author_dashboard'])->middleware('author')->name('author.dashboard');
Route::get('/authors', [UserController::class, 'authors'])->name('authors');
Route::get('/authors/status/{author_id}', [UserController::class, 'authors_status'])->name('authors.status');
Route::get('/authors/delete/{author_id}', [UserController::class, 'authors_delete'])->name('authors.delete');
Route::get('/authors/edit', [AuthorController::class, 'authors_edit'])->name('authors.edit');
Route::post('/authors/profile/update', [AuthorController::class, 'author_profile_update'])->name('author.profile.update');
Route::post('/authors/pass/update', [AuthorController::class, 'author_pass_update'])->name('author.pass.update');
Route::get('/authors/verify/{token}', [AuthorController::class, 'author_verify'])->name('author.verify');
Route::get('/request/verify', [AuthorController::class, 'request_verify'])->name('request.verify');
Route::post('/request/verify/sent', [AuthorController::class, 'request_verify_sent'])->name('request.verify.sent');

//Post
Route::get('/add/post', [PostController::class, 'add_post'])->name('add.post');
Route::post('/post/store', [PostController::class, 'post_store'])->name('post.store');
Route::get('/my/post', [PostController::class, 'my_post'])->name('my.post');
Route::get('/my/post/status/{post_id}', [PostController::class, 'my_post_status'])->name('my.post.status');
Route::get('/my/post/delete/{post_id}', [PostController::class, 'my_post_delete'])->name('my.post.delete');
Route::get('/post/details/{slug}', [FrontendController::class, 'post_details'])->name('post.details');
Route::get('/author/post/{author_id}', [FrontendController::class, 'author_post'])->name('author.post');
Route::get('/category/post/{category_id}', [FrontendController::class, 'category_post'])->name('category.post');

//Search
Route::get('/search', [FrontendController::class, 'search'])->name('search');
Route::get('/tag/post/{tag_id}', [FrontendController::class, 'tag_post'])->name('tag.post');

//Comments
Route::post('/comment/store', [FrontendController::class, 'comment_store'])->name('comment.store');

//Role
Route::get('/role', [RoleController::class, 'role'])->name('role');
Route::post('/permission/store', [RoleController::class, 'permission_store'])->name('permission.store');
Route::post('/role/store', [RoleController::class, 'role_store'])->name('role.store');
Route::post('/role/assign', [RoleController::class, 'role_assign'])->name('role.assign');
Route::get('/role/delete/{role_id}', [RoleController::class, 'role_delete'])->name('role.delete');
Route::get('/role/remove/{user_id}', [RoleController::class, 'role_remove'])->name('role.remove');