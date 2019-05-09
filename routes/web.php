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

use Illuminate\Http\Request;

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
    Route::get('/errorlog', 'PageController@errorlogs');
    /* End of Page Controller */

    /* AjaxController */
    Route::post('ajax/errorcode', 'AjaxController@errorcode');
    Route::post('ajax/Check_Record', 'AjaxController@checkRecord');
    Route::post('ajax/loaddatatable', 'AjaxController@LoadDataToTable');
    Route::post('ajax/saploaddatatable', 'AjaxController@SAPLoadDataToTable');
    Route::post('ajax/totalpjo', 'AjaxController@TotalPerJO');
    Route::post('ajax/empPIN', 'AjaxController@checkPINemployee');
    Route::post('ajax/feedlist', 'AjaxController@CheckFeederList');
    Route::post('ajax/loadDetails', 'AjaxController@LoadDetailsPanel');
    Route::post('ajax/loadhistory', 'AjaxController@LoadHistoryTable');
    Route::post('ajax/CheckRunningTable', 'AjaxController@CheckRunningTable');
    Route::post('ajax/MatHistExport', 'AjaxController@ExportMatHistory')->name('Matexport');
    Route::post('ajax/LoadRunning', 'AjaxController@LoadRunningTbl');
    Route::post('ajax/LoadFeederRunningTable', 'AjaxController@LoadFeederRunningTable');
    Route::post('ajax/ScanEmpID', 'AjaxController@ScanEmpID');
    Route::post('ajax/ScanRecordExport', 'AjaxController@ExportScanRecord')->name('ScanRecordexport');
    Route::post('ajax/AutoScanRecordExport', 'AjaxController@AutoExportScanRecord')->name('AutoScanRecordExport');
    Route::post('ajax/ErrorExpo', 'AjaxController@ExportError')->name('ErrorExport');
    Route::post('ajax/ErrorIns', 'AjaxController@ErrorInsert');
    Route::post('ajax/loadError', 'AjaxController@LoadError');
    /* End of Ajax Controller */


    Route::resource('scanrecord','ScanrecordController');
    Route::resource('materialload','MaterialLoadController');

    Route::post('scanrecord/upOUT', 'ScanrecordController@updateOUT');


});

/* PCB scanning */
Route::get('sp', 'ScanPcbController@index');
/* Scan Setting */
Route::get('scansetting', 'ScanPcbController@scansetting');
/* Defect Scanning */
Route::get('ds', 'DefectController@index');
/* Check Employee PIN */
Route::post('scanpinemp', 'DefectController@scanpinemp');
/* QR Generate */
/* Route::get('qr-code', 'ScanPcbController@qrgen'); */
Route::get('qr-code', function (Request $request) {
    return QrCode::size(250)->generate($request->url);
});

/* ---------- API NAMESPACE --------------- */
Route::namespace('Api')->group(function () {

    /* temp store defect mats */
    Route::post('defectmats_temp', 'DefectController@tempstore');
    /* Repairing Defect mats */
    Route::post('defectmats_rep/{id}', 'DefectController@repairdef');

    Route::prefix('api')->group(function () {
        /* Check Employee PIN */
        Route::get('scanpinemp', 'ApiController@scanpinemp');
        Route::get('divprocesses/{id}', 'ApiController@divprocesses');
        Route::get('linenames/{id}', 'ApiController@linenames');
        Route::get('loadWOtable', 'ApiController@loadWOtable');
    }); 
});

/* ----- MES ----- */
Route::get('smtmasterdb', 'MES\view\MasterController@index');
Route::get('fl', 'MES\view\MasterController@feederlist');
Route::get('cl', 'MES\view\MasterController@components');
Route::get('ls', 'MES\view\MasterController@linestruc');
Route::get('el', 'MES\view\MasterController@employee');
Route::get('ml', 'MES\view\MasterController@machine');
Route::get('ln', 'MES\view\MasterController@line');

// create feederlist
Route::get('cflh', 'MES\view\MasterController@createfeederlisthome');
Route::get('cfln', 'MES\view\MasterController@createfeederlistnew');
Route::get('cflv', 'MES\view\MasterController@createfeederlistversion');

// Searching
/* Route::post('fl/search', 'MES\view\MasterController@searchmodel'); */

// view feeder list details
Route::get('fld/{id}/{mid}', 'MES\view\MasterController@feederlistdetails');
// rendering tables per machine
Route::get('fldmach/{mach}/{id}', 'MES\view\MasterController@getmachtables');

// Tables
Route::resources([
    'feeders' => 'MES\api\FeedersController',
    'components' => 'MES\api\ComponentsController',
    'models' => 'MES\api\ModelsController',
    'lines' => 'MES\api\LinesController',
    'employees' =>  'MES\api\EmployeesController',
    'machines' =>  'MES\api\MachinesController',
    'linenames' =>  'MES\api\LineNamesController',
    'defectmats' => 'Api\DefectController',
    'processes' => 'Api\ProcessController',
    'defects' => 'Api\DefectCodeController',
    'divprocesses' => 'Api\DivProcessController'
]);
// deleting mount
Route::post('del_mount', 'MES\api\FeedersController@del_mount');
// changing mount
Route::post('change_mount', 'MES\api\FeedersController@change_mount');
// transferring mount
Route::post('transfer_mount', 'MES\api\FeedersController@transfer_mount');

// Testing
Route::get('testt', function () {
    $a = \App\Http\Controllers\MES\model\Machine::where('machine_type_id',1)->orderBy('id','DESC')->pluck('code')->first();
    return substr($a,6,2)+1;
});

/* ----- MES END ----- */

/* ----- MES2 start ----- */
Route::resource('process','MES2\ProcessController');
Route::get('processDelete', 'MES2\ProcessController@destroy');

Route::resource('defecttype','MES2\DefectTypeController');
/* ----- MES2 END ----- */

