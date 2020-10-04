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



Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard')->middleware('auth');

Route::get('/home', 'DashboardController@index')->name('dashboard')->middleware('auth');
Route::get('/leadschart','DashboardController@leadschart')->name('leadschart');;


Route::get('/import', 'ImportController@getImport')->name('import');
Route::post('/import_parse', 'ImportController@parseImport')->name('import_parse');
Route::post('/import_process', 'ImportController@processImport')->name('import_process');

Route::get('/leads', 'LeadsController@Index')->name('contactszz');
Route::post('/downloadleads', 'LeadsController@exportLeads')->name('exportLeads');
#Route::post('/leadwashing/exportunique', 'LeadsController@exportUniqueLeads')->name('exportUniqueLeads');
#Route::post('/leadwashing/exportduplicate', 'LeadsController@exportDuplicateLeads')->name('exportDuplicateLeads');
Route::get('/leadwashing/exportduplicate', 'LeadsController@exportDuplicateLeads2')->name('exportDuplicateLeads2');
Route::get('/leadwashing/exportunique', 'LeadsController@exportUniqueLeads')->name('exportUniqueLeads');
Route::get('/export', 'LeadsController@export')->name('export');

Route::get('/contacts', 'LeadsController@contacts')->name('contacts');

Route::get('/newleads', 'ImportController@getNewLeads')->name('newleads');
Route::post('/newleads_parse', 'ImportController@parseNewLeads')->name('newleads_parse');
Route::post('/newleads_process', 'ImportController@processNewLeads')->name('newleads_process');
Route::get('/new_leads_report', 'ImportController@newleadsReport')->name('newleadsReport');

Route::get('/campaigns', 'CampaignController@index')->name('campaigns');
Route::post('/createcampaign', 'CampaignController@createCampaign')->name('createCampaign');
Route::get('/deletecampaign/{id}', 'CampaignController@deleteCampaign')->name('deleteCampaign');
Route::post('/editcampaign', 'CampaignController@editCampaign')->name('editCampaign');

Route::get('/supplier', 'SupplierController@supplier')->name('supplier');
Route::post('/createsupplier', 'SupplierController@createSupplier')->name('createSupplier');
Route::get('/deletesupplier/{id}', 'SupplierController@deleteSupplier')->name('deleteSupplier');
Route::post('/editsupplier', 'SupplierController@editSupplier')->name('editSupplier');

Route::get('/reports', 'ReportsController@fetchReport')->name('fetchReport');

/**
 * middleware('App\Http\Middleware\AdminMiddleware')->
 * Route::get('/', 'ImportController@getImport')->name('import');
Route::post('/import_parse', 'ImportController@parseImport')->name('import_parse');
Route::post('/import_process', 'ImportController@processImport')->name('import_process'); */