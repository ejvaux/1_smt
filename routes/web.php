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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



/* PageController */
Route::get('/scan', 'PageController@scan');

/* End of Page Controller */

/* AjaxController */
Route::post('ajax/errorcode', 'AjaxController@errorcode');
Route::post('ajax/Check_Record', 'AjaxController@checkRecord');
Route::post('ajax/loaddatatable', 'AjaxController@LoadDataToTable');
/* End of Ajax Controller */


Route::resource('scanrecord','ScanrecordController');
Route::post('scanrecord/upOUT', 'ScanrecordController@updateOUT');