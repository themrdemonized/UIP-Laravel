<?php
//Route::get('/admin', 'AdminSpaController@index');

//Route::get('/', 'SpaController@index');

//Route::get('/read', 'ReadController@read');
Route::get('/downloadExcelFlats', 'FlatController@download');
Route::get('/{any}', 'SpaController@index')->where('any', '.*');

