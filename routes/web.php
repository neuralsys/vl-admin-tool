<?php

use Illuminate\Support\Facades\Route;

$middleware = config('vl_admin_tool.admin_middleware', 'admin.user');

Route::group(['middleware' => $middleware], function () {
    Route::resource('models', 'ModelController')->parameter('models', 'id');

    Route::resource('fields', 'FieldController')->parameter('fields', 'id');

    Route::resource('relations', 'RelationController')->parameter('relations', 'id');

    Route::resource('menus', 'MenuController')->parameter('menus', 'id');

    Route::resource('langs', 'LangController')->parameter('langs', 'id');

    Route::resource('translationFiles', 'TranslationFileController')->parameter('translationFiles', 'id');

    Route::resource('translations', 'TranslationController')->parameter('translations', 'id');
});
