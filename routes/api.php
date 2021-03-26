<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('auth/login', 'Api\\AuthController@login');

Route::group(['middleware' => ['apiJwt']], function (){




Route::post('auth/logout', 'Api\\AuthController@logout');

Route::get('teachers', 'Api\\TeacherController@index');

Route::get('discipline/{code?}', 'Api\\DisciplineController@index');
Route::post('new/discipline', 'Api\\DisciplineController@store');
Route::put('edit/discipline/{code}', 'Api\\DisciplineController@update');
Route::delete('delete/discipline/{code}', 'Api\\DisciplineController@destroy');

Route::get('classe/{code?}', 'Api\\ClasseController@index');
Route::post('new/classe', 'Api\\ClasseController@store');
Route::put('edit/classe/{id}', 'Api\\ClasseController@update');
Route::delete('delete/classe/{id}', 'Api\\ClasseController@destroy');




});















