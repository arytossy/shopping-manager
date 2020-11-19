<?php

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

// トップページ
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('threads.index');
    } else {
        return view('welcome');
    }
});

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ユーザー登録
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name('register.post');

// メインコンテンツ（認証済みユーザーのみ）
Route::middleware(['auth'])->group(function () {
    // プロフィール
    Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
    Route::put('profile/update', 'ProfileController@update')->name('profile.update');
    // 友だち
    Route::prefix('friends')->group(function () {
        Route::get('index', 'FriendController@index')->name('friends.index');
        Route::post('add', 'FriendController@add')->name('friends.add');
        Route::post('accept', 'FriendController@accept')->name('friends.accept');
        Route::post('destroy', 'FriendController@destroy')->name('friends.destroy');
    });
    // メンバー
    Route::prefix('members')->group(function () {
        Route::post('add', 'MemberController@add')->name('members.add');
        Route::post('destroy', 'MemberController@destroy')->name('members.destroy');
    });
    // オーダー
    Route::prefix('orders')->group(function () {
        Route::post('add', 'OrderController@add')->name('orders.add');
        Route::post('destroy', 'OrderController@destroy')->name('orders.destroy');
    });
    // リソース
    Route::resource('threads', 'ThreadController')->only(['index', 'create', 'store', 'show', 'update']);
    Route::resource('items', 'ItemController')->only(['store', 'update', 'destroy']);
    Route::resource('messages', 'MessageController')->only(['store', 'destroy']);

});