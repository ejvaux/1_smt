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

/* Route::get('/', function () {
    return view('welcome');
}); */

// Enabling DEBUGBAR in Production Only for Developers
/* if(in_array(\Request::ip(),['172.16.1.14','172.16.4.32'])){
    config(['app.debug' => TRUE]);
} */

Auth::routes();
Route::get('/', 'HomeController@index');
Route::get('sys_optimize', 'HomeController@sysOptimize');
Route::get('sys_routes', 'HomeController@sysRoutes');

// Overview
Route::get('/ov', 'HomeController@overview');
Route::get('/lineov', 'HomeController@line');
Route::get('/defectov', 'HomeController@defect');
Route::get('/joov', 'HomeController@joborder');

Route::group(['middleware' => 'auth'], function () {
    // All my routes that needs a logged in user
    /* Route::get('/', 'HomeController@index'); */

    /* PageController */
    Route::get('/scan', 'PageController@scan');
    Route::get('/mscan', 'PageController@mscan');       
    Route::get('/errorlog', 'PageController@errorlogs');
    /* End of Page Controller */
    
    Route::resource('scanrecord','ScanrecordController');
    

    Route::post('scanrecord/upOUT', 'ScanrecordController@updateOUT');

});
Route::get('/mscan2', 'PageController@mscan2');
Route::get('loadreplenish', 'AjaxController@loadreplenish');
Route::get('checkreplenish', 'AjaxController@checkreplenish');
Route::get('compareReel', 'AjaxController@compareReel');
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
/* PCB Automatic Scanning */
Route::get('autoscan', 'ScanPcbController@auto');
/* Scan Setting */
Route::get('scansetting', 'ScanPcbController@scansetting');
/* Defect Scanning */
Route::get('ds', 'DefectController@index');
/* Exporting Defect Mats */
Route::get('exportdefectmats', 'DefectController@exportdefectmats');
/* Check Employee PIN */
Route::post('scanpinemp', 'DefectController@scanpinemp');
/* Export Page */
Route::get('ep', 'ExportsController@index');
/* Export SN */
Route::get('ep/sn', 'ExportsController@exportpcb');
/* JO Tracking */
Route::get('jo', 'JoController@index');
Route::get('joqty', 'JoController@getJOqty');
/* Process Tracking */
Route::get('pt', 'TrackingController@process');
Route::get('ptcheck', 'TrackingController@checkprocess');
/* Line Results */
Route::get('lr', 'LineResultController@index');
Route::get('rt', 'LineResultController@resultTable');
Route::get('exportlr', 'LineResultController@exportlineresult');
/* Work Order Results */
Route::get('wor', 'ResultsController@index');
/* Overall line Results */
Route::get('lsr', 'ResultsController@summary');
Route::get('gs', 'ResultsController@getSummary');
/* Serial Number - Work Order */
Route::get('sr', 'SnReelController@index');
Route::get('loadreel', 'SnReelController@loadreel');
Route::get('loadsn', 'SnReelController@loadsn');
Route::get('loadpn', 'SnReelController@loadpn');
Route::post('loadsnpn', 'SnReelController@loadsnpn');
Route::get('exportreel', 'SnReelController@exportreel');
Route::get('exportpnrid', 'SnReelController@exportpnrid');
Route::get('exportrlsn', 'SnReelController@exportrlsn');
Route::post('exportsnpn', 'SnReelController@exportsnpn');
/* Material Load List */
Route::get('mll', 'TrackingController@matloadlist');
Route::get('mload', 'TrackingController@loadlist');
Route::get('matcompdel', 'TrackingController@matcompdel');

/* QR Generate */
Route::get('qrcode', 'PageController@qrgen');

/* ---------- API NAMESPACE --------------- */
Route::namespace('Api')->group(function () {

    /* temp store defect mats */
    Route::post('defectmats_temp', 'DefectController@tempstore');
    /* Repairing Defect mats */
    Route::post('defectmats_rep/{id}', 'DefectController@repairdef');
    Route::post('defectmats_rep1', 'DefectController@repairdef1');    

    Route::prefix('api')->group(function () {

        Route::post('scanserial', 'ApiController@scantype');
        Route::get('divprocesses/{id}', 'ApiController@divprocesses');
        Route::get('linenames/{id}', 'ApiController@linenames');

        /* Check Employee PIN */        
        Route::get('scanpinemp', 'ApiController@scanpinemp');

        /* Check Serial NO */
        Route::get('checksn', 'ApiController@checksn');
        Route::get('repairchecksn', 'DefectController@repairchecksn');

        /* Lot Number */
        Route::get('getln', 'ApiController@getlotnumber');
        Route::get('getlntotal', 'ApiController@getlotnumbertotal');
        Route::post('createln', 'ApiController@createlotnumber');
        Route::post('closeln', 'ApiController@closelotnumber');
        Route::get('getlc', 'ApiController@getlotconfig');

        /* Load Tables */
        Route::get('loadWOtable', 'ApiController@loadWOtable');
        Route::get('loadpcbtable', 'ApiController@loadpcbtable');
        Route::get('loadempscantotaltable', 'ApiController@loadempscantotaltable');
        Route::get('loadlocation', 'DefectController@loadlocation');

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
Route::get('pr', 'MES\view\MasterController@process');
Route::get('dt', 'MES\view\MasterController@defecttype');
Route::get('lcl', 'MES\view\MasterController@lineconfig');
Route::post('lcu', 'MES\view\MasterController@lineconfigUpdate');

/* ----- Export ----- */
Route::get('exportel', 'MES\api\EmployeesController@exportemployee');

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
    'defecttypes' =>  'MES\api\DefectTypesController',
    'defectmats' => 'Api\DefectController',
    'processes' => 'MES\api\ProcessController',
    'defects' => 'Api\DefectCodeController',
    'divprocesses' => 'Api\DivProcessController'
]);
// deleting mount
Route::post('del_mount', 'MES\api\FeedersController@del_mount');
// changing mount
Route::post('change_mount', 'MES\api\FeedersController@change_mount');
// transferring mount
Route::post('transfer_mount', 'MES\api\FeedersController@transfer_mount');
// update usage
Route::post('update_usage', 'MES\api\FeedersController@update_usage');
// delete maching
Route::post('del_machine', 'MES\api\FeedersController@del_machine');

// Testing
Route::get('testt', 'PageController@testing');
Route::post('testt', 'PageController@testing');

/* ----- MES END ----- */

/* ----- MES2 start ----- */

/* Route::resource('process','MES2\ProcessController'); */
Route::get('processDelete', 'MES2\ProcessController@destroy');
Route::resource('defecttype','MES2\DefectTypeController');
Route::get('tracking','TrackingController@pcb');
Route::resource('tc','MES2\trackingComponentController');
Route::resource('qc','MES2\qcController');
Route::get('qcs','MES2\qcController@searchdate');
Route::get('qcl','MES2\qcController@searchlot');
Route::get('qcgood','MES2\qcController@updategood');
Route::get('qcnogood','MES2\qcController@updatenogood');
Route::get('cld','MES2\qcController@checklotdetails');

/* ----- MES2 END ----- */

