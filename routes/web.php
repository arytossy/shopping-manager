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
Route::get('/', 'TopController');

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
        Route::get('get', 'FriendController@get_friends')->name('friends.get');
    });
    // メンバー
    Route::prefix('members')->group(function () {
        Route::get('', 'MemberController@index')->name('members.index');
        Route::post('add', 'MemberController@add')->name('members.add');
        Route::post('destroy', 'MemberController@destroy')->name('members.destroy');
    });
    // オーダー
    Route::prefix('orders')->group(function () {
        Route::post('add', 'OrderController@add')->name('orders.add');
        Route::post('change', 'OrderController@change')->name('orders.change');
        Route::post('destroy', 'OrderController@destroy')->name('orders.destroy');
    });
    // リソース
    Route::resource('threads', 'ThreadController')->only(['index', 'create', 'store', 'show', 'update']);
    Route::resource('items', 'ItemController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('messages', 'MessageController')->only(['index', 'store', 'destroy']);


    //===== 改善案 ====================================================================================
    // Route::prefix('app')->group(function () {
    //     Route::get('mypage', 'AppController@mypage')->name('mypage');
    //     Route::get('threads/{id}', 'AppController@threadpage')->name('threadpage');
    // });

    // Route::prefix('resources')->group(function () {
    //     Route::prefix('users')->group(function () {
    //         Route::post('search', 'UserController@search')->name('users.search');
    //     });
    //     Route::prefix('threads')->group(function () {
    //         Route::get('', 'ThreadController@index')->name('threads.index');
    //         Route::post('', 'ThreadController@store')->name('threads.store');
    //         Route::put('{id}', 'ThreadController@update')->name('threads.update');
    //         Route::delete('{id}', 'ThreadController@destroy')->name('threads.destroy');
    //     });
    //     Route::prefix('items')->group(function () {
    //         Route::get('', 'ItemController@index')->name('items.index');
    //         Route::post('', 'ItemController@store')->name('items.store');
    //         Route::put('{id}', 'ItemController@update')->name('items.update');
    //         Route::delete('{id}', 'ItemController@destroy')->name('items.destroy');
    //     });
    //     Route::prefix('messages')->group(function () {
    //         Route::get('', 'MessageController@index')->name('messages.index');
    //         Route::post('', 'MessageController@store')->name('messages.store');
    //         Route::put('{id}', 'MessageController@update')->name('messages.update');
    //         Route::delete('{id}', 'MessageController@destroy')->name('messages.destroy');
    //     });
    // });

    // Route::prefix('relations')->group(function () {
    //     Route::prefix('friends')->group(function () {
    //         Route::get('', 'FriendController@index')->name('friends.index');
    //         Route::post('add', 'FriendController@add')->name('friends.add');
    //         Route::post('remove', 'FriendController@remove')->name('friends.remove');
    //         Route::post('accept', 'FriendController@accept')->name('friends.accept');
    //     });
    //     Route::prefix('members')->group(function () {
    //         Route::get('', 'MemberController@index')->name('members.index');
    //         Route::post('add', 'MemberController@add')->name('members.add');
    //         Route::post('remove', 'MemberController@remove')->name('members.remove');
    //     });
    //     Route::prefix('orders')->group(function () {
    //         Route::get('', 'OrderController@index')->name('orders.index');
    //         Route::post('add', 'OrderController@add')->name('orders.add');
    //         Route::post('remove', 'OrderController@remove')->name('orders.remove');
    //     });
    // });
    //=========================================================================================

    
    // Ajax用エントリポイント
    Route::prefix('ajax')->group(function () {
        Route::post('users/search', 'AjaxController@users_search')->name('ajax.users.search');
    });

});