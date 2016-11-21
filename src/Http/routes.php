<?php
Route::group(['middleware' => ['web']], function () {
    if ($dest = config('larauser.routes.edit')) {
        Route::get($dest,  ['as' => 'larauser.edit', 'uses' => 'UserController@edit'])->middleware('auth');
        Route::post($dest, ['as' => 'larauser.update', 'uses' => 'UserController@update'])->middleware('auth');
    }
    if ($dest = config('larauser.routes.add')) {
        Route::get($dest,  ['as' => 'larauser.add',   function() { return view('larauser::user.add'); }])->middleware('guest');
        Route::post($dest, ['as' => 'larauser.store', 'uses' => 'UserController@store'])->middleware('guest');
    }
});
?>