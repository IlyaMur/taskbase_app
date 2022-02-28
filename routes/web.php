<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::controller('ProjectController')->group(function () {
        Route::get('/', 'index');
        Route::get('/projects', 'index');
    });
    Route::get('/projects/create', 'ProjectController@create');
    Route::get('/projects/{project}', 'ProjectController@show');
    Route::get('/projects/{project}/edit', 'ProjectController@edit');
    Route::post('/projects', 'ProjectController@store');

    Route::post('/projects/{project}/tasks', "ProjectTasksController@store");
    Route::patch('/projects/{project}/tasks/{task}', "ProjectTasksController@update");
    Route::patch('/projects/{project}', "ProjectController@update");
});

Auth::routes();
