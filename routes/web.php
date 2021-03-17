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
Route::any('/login2', function (){
    return view('login.index');
})->name('login2');

Route::any('/login', function (){
    return view('login.index2');
})->name('login');

Route::any('/logout', 'AuthLogout@logout')->name('logout');


Route::any('/', 'AuthLogin@login')->name('check');

Route::post('/login-api','AuthLogin@login_api')->name('login_api');

Route::middleware('auth')->group (function (){

    // Route::get('/', function () {
    //     return view('/home');
    // });

    Route::get('/', 'HomeController@index')->name('home');
    Route::GET('/selectAnes', 'HomeController@index')->name('selectAnes');
    Route::get('/accept','HomeController@accept');
    // Route::post('/', 'HomeController@index')->name('home');

    // Route::get('/', 'HomeController@patNoRsrv')->name('patNoRserve');

    Route::get('/anesSched', 'ReservationController@anesSched')->name('anesSched');
    Route::any('/anesSched2', 'ReservationController@anesSched2')->name('anesSched2');
    Route::post('/getAnesUpdate', 'ReservationController@getAnesUpdate')->name('getUpdate');

    Route::any('/myschedules', 'ReservationController@myschedules')
        ->name('myschedules');

    Route::any('/schedlist', 'ReservationController@schedlist')->name('schedlist');
    Route::GET('/schedlist_gen', 'ReservationController@schedlist_gen')->name('schedlist_gen');

    Route::get('calendarView', 'ReservationController@newCalendar')->name('calendarView');
    Route::get('/selectdate', 'ReservationController@storeCalendar');

    Route::GET('/selectdateroom', 'ReservationController@selectdateroom')->name('selectdateroom');

    Route::get('/mypatients', 'PatientController@mypatients')->name('mypatients');
    Route::get('/histoPat', 'PatientController@histoPat')->name('histoPat');
    Route::any('/addpatient', 'PatientController@addpatient')->name('addpatient');

    Route::post('/JS/genpatientlist', 'PatientController@JS_GenPatientList');
    Route::post('/JS/genenclist', 'PatientController@JS_GenEncounterList');

    Route::post('/patientdetails', 'PatientController@patientdetails');

    Route::post('/JSON/patdetails', 'PatientController@patdetails');

    Route::get('/Rooms', 'RoomController@index')->name('Rooms');

    Route::get('/User', 'UserController@index')->name('UserMaintenance');
    Route::get('/user/employeedetails', 'UserController@empdetails')->name('employeedetails');
    Route::post('/changeRole', 'UserController@changeRole')->name('changeRole');
    Route::get('/change', 'UserController@change');

    Route::post('/selectdateroom2', 'RoomController@selectdateroom2');

    Route::post('/addschedule', 'ReservationController@addschedule')->name('addschedule');
    Route::post('/addschedule2', 'ReservationController@emerSchedule')->name('emerSchedule');

    // REPORTS
    Route::get('/index','ReportsController@index')->name('index');
    Route::get('/r1','ReportsController@r1')->name('emergent');
    Route::post('/r1Post','ReportsController@r1Post')->name('emergent_filter');

    Route::get('/r2','ReportsController@r2')->name('elective');
    Route::post('/r2Post','ReportsController@r2Post')->name('elective_filter');

    Route::get('/all','ReportsController@all')->name('all');
    Route::post('/allPost','ReportsController@allPost')->name('all_filter');

    Route::get('/anesEmer','ReportsController@anesEmer')->name('anesEmer');
    Route::post('/anesEmerFilter','ReportsController@anesEmerFilter')->name('anesEmerFilter');

    Route::get('/anesElec','ReportsController@anesElec')->name('anesElec');
    Route::post('/anesElecFilter','ReportsController@anesElecFilter')->name('anesElecFilter');

    Route::get('/anesReport','ReportsController@anesReport')->name('anesReport');
    Route::get('/anesAll','ReportsController@anesAll')->name('anesAll');

    // 
    Route::get('/date','ReportsController@r1')->name('EmerReport');


    // PRINT REPORTS 
    Route::get('/print/r1','ReportsController@print1')->name('print_emergent');
    Route::get('/print/r2','ReportsController@print2')->name('print_elective');
    Route::get('/print/all','ReportsController@printAll')->name('print_all');
    Route::get('/print/anesAll','ReportsController@anesAllPrint')->name('anesAll_print');
    Route::get('/print/anesEmer','ReportsController@anesEmerPrint')->name('anesEmer');
    Route::get('/print/anesElec','ReportsController@anesElecPrint')->name('anesElec');

    //LOGS
    Route::get('/translog','ReportsController@trans_log')->name('translog');
    
    // UPDATES HERE
    Route::get('/remarks', 'ReservationController@remarks');
    // CHANGE ANNEX
    Route::get('/change_annex','ReservationController@change_annex');

    // CANCEL SCHEDULE
    Route::get('/cancel_schedule', 'CancelAndEditSchedule@cancelSChedule');

    // DEFER SCHEDULE
    Route::get('/defer_schedule', 'CancelAndEditSchedule@defer');
    
    // UNDODEFER SCHEDULE
    Route::get('/undo_defer', 'CancelAndEditSchedule@undo_defer');

    //CHANGE TIME
    Route::post('/changetime' , 'CancelAndEditSchedule@EditSchedule')->name('changetime');

    //STATUS
    Route::get('/status', 'RoomController@status');

    // ADD ANES
    Route::post('/anes', 'ReservationController@addAnes')->name('addAnes');
    // ADD ANES HOME
    Route::post('/anesHome', 'HomeController@addAnes')->name('addAnes');

    // USER MANUAL
    Route::get('/ChartReport', 'HomeController@ChartReport')->name('ChartReport');
    Route::post('/Charts', 'HomeController@Charts')->name('Charts');



    Route::post('/isConfirm','HomeController@is_confirm');
});
