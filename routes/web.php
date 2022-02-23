<?php

use App\Models\Project;
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

Route::get('/projects', 'ProjectController@index');

Route::post('/projects', 'ProjectController@store')->middleware('auth');
Route::get('/projects/{project}', 'ProjectController@show')->name('projects.show');

Route::get('/', fn () => view('welcome'));

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
