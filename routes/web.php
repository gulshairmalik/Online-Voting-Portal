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

Route::get('/','PagesController@index');
Route::get('index','PagesController@index');
Route::post('register','PagesController@formValidation');
Route::get('login','PagesController@login_page');
Route::get('register','PagesController@reg_page');
Route::post('index','PagesController@store');
Route::post('login','PagesController@user_auth');
Route::post('admin','AdminController@organize');
Route::get('logout','PagesController@logout');
Route::get('admin','PagesController@login_page');
Route::post('user','PagesController@cast_vote');
Route::post('verify_vote','PagesController@verify_vote');
Route::post('result','PagesController@show_result');
Route::post('end','PagesController@end_election');
Route::get('result','PagesController@login_page');
Route::get('end','PagesController@login_page');
Route::get('organize','PagesController@login_page');
Route::post('organize','PagesController@new_election');