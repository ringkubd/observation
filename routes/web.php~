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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware("verified");
Route::resource("client","ClientController")->middleware(["haveAccess:client","verified"]);
Route::resource("branch","BranchController")->middleware(["haveAccess:branch","verified"]);

Route::resource("/employee","EmployeeController")->middleware(["haveAccess:employee","verified"]);


Route::get('__sbbranch', 'BranchController@__getSubBranch')->name('__sbbranch');
Route::get('getSub_subBranch', 'BranchController@getSub_subBranch')->name('getSub_subBranch');
Route::get('sbbranch', 'BranchController@getSubBranch')->name('sbbranch');
Route::get('default_branch', 'BranchController@selected_branch')->name('default_branch');