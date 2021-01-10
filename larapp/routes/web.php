<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

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

Route::get('/', 'HomeController@welcome');

Route::get('helloworld', function () {
    dd('Hello alejo');
});

Route::get('users', function () {
    dd(App\User::all()); 
});

Route::get('user/{id}', function ($id) {
    dd(App\User::findOrFail($id)); 
});

Route::get('edades', function () {
    $users = (App\User::all()->take(10));
    for($i = 0; $i<count($users); $i++) {
        $userAge = Carbon::parse($users[$i]->birthdate)->age;
        $created = $users[$i]->created_at->diffForHumans();
        $rs[] = $users[$i]->fullname." - "."$userAge"." years old"." - "." created ".$created."; ";   
    }

    return view('callenge', ['rs' => $rs]);
});

Route::get('examples', function() {
    $users = (App\User::all()->take(5));
    return view('example',['show' => 'both', 'day' => 'wednesday','users' => $users]);
});


Auth::routes();

// Group Middleware
Route::group(['middleware' => 'admin'], function() {
    // Resources
    Route::resources([
        'users'       => 'UserController',
        'categories'  => 'CategoryController',
        'games'       => 'GameController',
    ]);
});

Route::group(['middleware' => 'editor'], function() {
    // Resources
    Route::resources([
        'games'       => 'GameController',
    ]);
});

// Dashboard Customer
Route::put('customer/{id}', 'UserController@customerupd');
// Dashboard Editor
Route::get('editor/info', 'UserController@editorinfo');
Route::put('editor/{id}', 'UserController@editorupd');

Route::get('editor/games', 'GameController@editorgames');


Route::get('generate/pdf/users', 'UserController@pdf');

Route::get('generate/pdf/games', 'GameController@pdf');

Route::get('generate/excel/users', 'UserController@excel');

Route::get('generate/excel/games', 'GameController@excel');

Route::post('import/excel/users', 'UserController@import');

Route::post('import/excel/games', 'GameController@import');

Route::post('users/search', 'UserController@search');

Route::post('games/search', 'GameController@search');

Route::get('locale/{locale}', 'LocaleController@index');

Route::get('/home', 'HomeController@index')->name('home');

Route::post('category/filter', 'HomeController@filter');


