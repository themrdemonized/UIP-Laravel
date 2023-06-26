<?php

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('me', 'AuthController@me');
        Route::post('logout', 'AuthController@logout');
    });
});

Route::group(['middleware'=>'auth:api'], function(){

    Route::prefix('admin')->group(function (){

        Route::prefix('attachments')->group(function() {
            Route::delete('{id}', 'AttachmentController@delete')->middleware('isAdmin');
        });

        Route::prefix('documents')->group(function(){
            Route::get('', 'DocumentController@index')->middleware('isAdmin');
            Route::get('{id}', 'DocumentController@show')->middleware('isAdmin');
            Route::post('', 'DocumentController@create')->middleware('isAdmin');
            Route::put('{id}', 'DocumentController@update')->middleware('isAdmin');
            Route::delete('{id}', 'DocumentController@destroy')->middleware('isAdmin');
        });

        Route::prefix('calls')->group(function() {
            Route::get('', 'CallController@index')->middleware('isAdmin');
            Route::put('{id}', 'CallController@update')->middleware('isAdmin');
            Route::delete('{id}', 'CallController@destroy')->middleware('isAdmin');
        });

        Route::prefix('news')->group(function() {
            Route::get('', 'NewwController@adminIndex')->middleware('isAdmin');
            Route::post('', 'NewwController@create')->middleware('isAdmin');
            Route::put('{id}', 'NewwController@update')->middleware('isAdmin');
            Route::delete('{id}', 'NewwController@destroy')->middleware('isAdmin');
        });

        Route::prefix('banks')->group(function() {
            Route::get('', 'BankController@index')->middleware('isAdmin');
            Route::get('{id}', 'BankController@show')->middleware('isAdmin');
            Route::post('', 'BankController@create')->middleware('isAdmin');
            Route::put('{id}', 'BankController@update')->middleware('isAdmin');
            Route::delete('{id}', 'BankController@destroy')->middleware('isAdmin');
        });

        Route::prefix('reserves')->group(function() {
            Route::get('', 'ReserveController@index')->middleware('isAdmin');
            Route::put('{id}', 'ReserveController@update')->middleware('isAdmin');
            Route::delete('{id}', 'ReserveController@destroy')->middleware('isAdmin');
        });

        Route::prefix('photoReports')->group(function() {
            Route::get('{id}', 'PhotoReportController@edit')->middleware('isAdmin');
            Route::put('{id}', 'PhotoReportController@update')->middleware('isAdmin');
            Route::post('', 'PhotoReportController@create')->middleware('isAdmin');
            Route::delete('{id}', 'PhotoReportController@delete')->middleware('isAdmin');
        });

        Route::prefix('pantries')->group(function() {
            Route::get('', 'PantryController@index')->middleware('isAdmin');
            Route::get('{id}', 'PantryController@edit')->middleware('isAdmin');
            Route::put('{id}', 'PantryController@update')->middleware('isAdmin');
            Route::post('', 'PantryController@create')->middleware('isAdmin');
            Route::delete('{id}', 'PantryController@delete')->middleware('isAdmin');
        });

        Route::prefix('offices')->group(function() {
            Route::get('{id}', 'OfficeController@edit')->middleware('isAdmin');
            Route::get('', 'OfficeController@search')->middleware('isAdmin');
            Route::put('{id}', 'OfficeController@update')->middleware('isAdmin');
            Route::post('', 'OfficeController@create')->middleware('isAdmin');
            Route::delete('{id}', 'OfficeController@delete')->middleware('isAdmin');
        });

        Route::prefix('users')->group(function() {
            Route::get('', 'UserController@index')->middleware('isAdmin');
            Route::get('{id}', 'UserController@show')->middleware('isAdmin');
            Route::put('{id}', 'UserController@update')->middleware('isAdmin');
            Route::delete('{id}', 'UserController@destroy')->middleware('isAdmin');
        });

        Route::prefix('objects')->group(function() {
            Route::put('{id}', 'ObjectController@update')->middleware('isAdmin');
            Route::post('', 'ObjectController@create')->middleware('isAdmin');
            Route::delete('{id}', 'ObjectController@delete')->middleware('isAdmin');
        });

        Route::prefix('houses')->group(function() {
            Route::put('{id}', 'HouseController@update')->middleware('isAdmin');
            Route::post('', 'HouseController@create')->middleware('isAdmin');
            Route::delete('{id}', 'HouseController@delete')->middleware('isAdmin');
            Route::get('{id}', 'HouseController@edit')->middleware('isAdmin');
        });

        Route::prefix('floors')->group(function() {
            Route::get('{id}', 'FloorController@edit')->middleware('isAdmin');
            Route::put('{id}', 'FloorController@update')->middleware('isAdmin');
            Route::post('', 'FloorController@create')->middleware('isAdmin');
            Route::delete('{id}', 'FloorController@delete')->middleware('isAdmin');
        });

        Route::prefix('flats')->group(function() {
            Route::get('', 'FlatController@adminIndex')->middleware('isAdmin');
            Route::get('{id}', 'FlatController@edit')->middleware('isAdmin');
            Route::put('{id}', 'FlatController@update')->middleware('isAdmin');
            Route::post('', 'FlatController@create')->middleware('isAdmin');
            Route::delete('{id}', 'FlatController@delete')->middleware('isAdmin');
        });

        Route::prefix('lots')->group(function() {
            Route::get('', 'LotController@adminIndex')->middleware('isAdmin');
            Route::get('{id}', 'LotController@edit')->middleware('isAdmin');
            Route::put('{id}', 'LotController@update')->middleware('isAdmin');
            Route::post('', 'LotController@create')->middleware('isAdmin');
            Route::delete('{id}', 'LotController@destroy')->middleware('isAdmin');
        });

        Route::prefix('rates')->group(function() {
            Route::delete('{id}', 'RateController@destroy')->middleware('isAdmin');
        });
    });


    Route::get('/admin/getObjects', 'AdminSpaController@getObjects')->middleware('isAdmin');
    Route::get('/admin/getHouses', 'AdminSpaController@getHouses')->middleware('isAdmin');
    Route::get('/admin/getFloors', 'AdminSpaController@getFloors')->middleware('isAdmin');
    Route::get('/admin/getFlats', 'AdminSpaController@getFlats')->middleware('isAdmin');

    Route::get('admin/updHousePrice', 'AdminSpaController@updHousePrice')->middleware('isAdmin');
    Route::get('admin/updFloorPrice', 'AdminSpaController@updFloorsPrice')->middleware('isAdmin');
    Route::get('admin/updFlatPrice', 'AdminSpaController@updFlatPrice')->middleware('isAdmin');

    Route::get('/admin/getDash', 'AdminSpaController@getDash')->middleware('isAdmin');
    Route::get('/admin/findFlats', 'AdminSpaController@findFlats')->middleware('isAdmin');
    Route::get('/admin/changeFlatStatus', 'AdminSpaController@changeFlatStatus')->middleware('isAdmin');


});

Route::get('/admin/getFlatss', function () {
   return response()->json([
       "flats" => \App\Flat::get()
   ], 200);
});

Route::post('/admin/upload', 'DocumentController@store');

Route::get('/objects/{id}', 'ObjectController@show');
Route::get('/objects', 'ObjectController@getObjects');
Route::get('/objectsForNav', 'ObjectController@getObjectsForNav');

Route::get('/houses/{id}', 'HouseController@show');
Route::get('/getHouses', 'HouseController@getHouses');

Route::get('/getFloor', 'FloorController@getFloor');

Route::get('/flats', 'FlatController@index');
Route::get('/flats/{id}', 'FlatController@show');

Route::get('/offices', 'OfficeController@index');
Route::get('/offices/{id}', 'OfficeController@show');

Route::get('/photoReports', 'PhotoReportController@index');


Route::post('/createCallBack', 'CallController@create');

Route::post('/reserves', 'ReserveController@create');

Route::get('/news', 'NewwController@index');
Route::get('/news/{id}', 'NewwController@show');

Route::get('/lots', 'LotController@index');
Route::get('/lots/{id}', 'LotController@show');

Route::post('/participants/check', 'ParticipantController@check');
Route::post('/participants/rates', 'ParticipantController@rates');
Route::post('/participants/checkIdentifier', 'ParticipantController@checkIdentifier');

Route::get('/robjects/{id}', 'FakeReserveController@getObjectForReserve');
Route::post('/reserve/create', 'FakeReserveController@create');

