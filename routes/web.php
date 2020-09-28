<?php

use Illuminate\Support\Facades\Route;

$middleware = config('vl_admin_tool.admin_middleware', 'admin.user');

Route::group(['middleware' => $middleware], function () {
    Route::resource('models', 'ModelController');

    Route::resource('relations', 'RelationController');

    Route::resource('menus', 'MenuController');

    Route::resource('langs', 'LangController');

    Route::resource('translationFiles', 'TranslationFileController');

    Route::resource('translations', 'TranslationController');
});
