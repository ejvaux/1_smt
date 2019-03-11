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



Route::group(['middleware' => 'auth'], function () {
    // All my routes that needs a logged in user
    Route::get('/home', 'HomeController@index')->name('home');

    /* PageController */
    Route::get('/scan', 'PageController@scan');
    Route::get('/mscan', 'PageController@mscan');
    /* End of Page Controller */

    /* AjaxController */
    Route::post('ajax/errorcode', 'AjaxController@errorcode');
    Route::post('ajax/Check_Record', 'AjaxController@checkRecord');
    Route::post('ajax/loaddatatable', 'AjaxController@LoadDataToTable');
    Route::post('ajax/saploaddatatable', 'AjaxController@SAPLoadDataToTable');
    Route::post('ajax/totalpjo', 'AjaxController@TotalPerJO');
    Route::post('ajax/empPIN', 'AjaxController@checkPINemployee');
    Route::post('ajax/feedlist', 'AjaxController@CheckFeederList');
    /* End of Ajax Controller */


    Route::resource('scanrecord','ScanrecordController');
    Route::post('scanrecord/upOUT', 'ScanrecordController@updateOUT');


});

/* Feeder List */
Route::get('/fl', 'feeder\view\FeederListController@index');
/* Route::get('/fl', function () {
    return "yes";
}); */

/* END - Feeder List */
