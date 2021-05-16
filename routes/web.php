<?php

use Illuminate\Support\Facades\Route;

$middleware = config('vl_admin_tool.admin_middleware', 'admin.user');

Route::group(['middleware' => $middleware], function () {
    Route::post('models/generate/{id}', 'ModelController@generate')->name('models.generate');
    Route::post('models/sync', 'ModelController@sync')->name('models.syncDB');
    Route::resource('models', 'ModelController')
        ->except('create', 'edit', 'show')
        ->parameter('models', 'id');

    Route::resource('fields', 'FieldController')
        ->except('create', 'edit', 'show')
        ->parameter('fields', 'id');

    Route::resource('dBConfigs', 'DBConfigController')
        ->except('create', 'edit', 'show')
        ->parameter('dBConfigs', 'id');

    Route::resource('cRUDConfigs', 'CRUDConfigController')
        ->except('create', 'edit', 'show')
        ->parameter('cRUDConfigs', 'id');

    Route::resource('dTConfigs', 'DTConfigController')
        ->except('create', 'edit', 'show')
        ->parameter('dTConfigs', 'id');

    Route::resource('relations', 'RelationController')
        ->except('create', 'edit', 'show')
        ->parameter('relations', 'id');

    Route::resource('menus', 'MenuController')
        ->except('create', 'edit', 'show')
        ->parameter('menus', 'id');

    Route::resource('langs', 'LangController')
        ->except('create', 'edit', 'show')
        ->parameter('langs', 'id');

    Route::resource('translationFiles', 'TranslationFileController')
        ->except('create', 'edit', 'show')
        ->parameter('translationFiles', 'id');

    Route::resource('translations', 'TranslationController')
        ->except('create', 'edit', 'show')
        ->parameter('translations', 'id');
});
