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
use App\Http\Controllers\MES\model\ModName;

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
    
    Route::resource('scanrecord','ScanrecordController');
    

    Route::post('scanrecord/upOUT', 'ScanrecordController@updateOUT');

});
Route::get('/mscan2', 'PageController@mscan2');
Route::resource('materialload','MaterialLoadController');
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

/* PCB scanning */
Route::get('sp', 'ScanPcbController@index');
/* Scan Setting */
Route::get('scansetting', 'ScanPcbController@scansetting');
/* Defect Scanning */
Route::get('ds', 'DefectController@index');
/* Check Employee PIN */
Route::post('scanpinemp', 'DefectController@scanpinemp');
/* Export Page */
Route::get('ep', 'ExportsController@index');
/* Export SN */
Route::get('ep/sn', 'ExportsController@exportpcb');


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

        /* Check Serial NO */
        Route::get('checksn', 'ApiController@checksn');

        Route::post('scanserial', 'ApiController@checkjoquantity');
        Route::get('divprocesses/{id}', 'ApiController@divprocesses');
        Route::get('linenames/{id}', 'ApiController@linenames');

        /* Load Tables */
        Route::get('loadWOtable', 'ApiController@loadWOtable');
        Route::get('loadpcbtable', 'ApiController@loadpcbtable');

        /* Total Scan */
        Route::get('totalscan', 'ApiController@totalscan');
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
Route::get('fld/{id}/{mid}/{linid}', 'MES\view\MasterController@feederlistdetails');
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
    
    return ModName::find(8);
});

/* ----- MES END ----- */

/* ----- MES2 start ----- */
Route::resource('process','MES2\ProcessController');
Route::get('processDelete', 'MES2\ProcessController@destroy');

Route::resource('defecttype','MES2\DefectTypeController');
/* ----- MES2 END ----- */

