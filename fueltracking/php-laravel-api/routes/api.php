<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// api routes that need auth

Route::middleware(['auth:api', 'rbac'])->group(function () {


/* routes for Kategori Controller  */	
	Route::get('kategori', 'KategoriController@index');
	Route::get('kategori/index', 'KategoriController@index');
	Route::get('kategori/index/{filter?}/{filtervalue?}', 'KategoriController@index');	
	Route::get('kategori/view/{rec_id}', 'KategoriController@view');	
	Route::post('kategori/add', 'KategoriController@add');	
	Route::any('kategori/edit/{rec_id}', 'KategoriController@edit');	
	Route::any('kategori/delete/{rec_id}', 'KategoriController@delete');

/* routes for Model_Has_Permissions Controller  */

/* routes for Model_Has_Roles Controller  */	
	Route::get('model_has_roles', 'Model_Has_RolesController@index');
	Route::get('model_has_roles/index', 'Model_Has_RolesController@index');
	Route::get('model_has_roles/index/{filter?}/{filtervalue?}', 'Model_Has_RolesController@index');	
	Route::get('model_has_roles/view/{rec_id}', 'Model_Has_RolesController@view');	
	Route::post('model_has_roles/add', 'Model_Has_RolesController@add');	
	Route::any('model_has_roles/edit/{rec_id}', 'Model_Has_RolesController@edit');	
	Route::any('model_has_roles/delete/{rec_id}', 'Model_Has_RolesController@delete');

/* routes for Pengajuan Controller  */	
	Route::get('pengajuan', 'PengajuanController@index');
	Route::get('pengajuan/index', 'PengajuanController@index');
	Route::get('pengajuan/index/{filter?}/{filtervalue?}', 'PengajuanController@index');	
	Route::get('pengajuan/view/{rec_id}', 'PengajuanController@view');	
	Route::post('pengajuan/add', 'PengajuanController@add');	
	Route::any('pengajuan/edit/{rec_id}', 'PengajuanController@edit');	
	Route::any('pengajuan/delete/{rec_id}', 'PengajuanController@delete');

/* routes for Permissions Controller  */

/* routes for Role_Has_Permissions Controller  */

/* routes for Roles Controller  */	
	Route::get('roles', 'RolesController@index');
	Route::get('roles/index', 'RolesController@index');
	Route::get('roles/index/{filter?}/{filtervalue?}', 'RolesController@index');	
	Route::get('roles/view/{rec_id}', 'RolesController@view');	
	Route::post('roles/add', 'RolesController@add');	
	Route::any('roles/edit/{rec_id}', 'RolesController@edit');	
	Route::any('roles/delete/{rec_id}', 'RolesController@delete');

/* routes for Tb_Bahanbakar Controller  */	
	Route::get('tb_bahanbakar', 'Tb_BahanbakarController@index');
	Route::get('tb_bahanbakar/index', 'Tb_BahanbakarController@index');
	Route::get('tb_bahanbakar/index/{filter?}/{filtervalue?}', 'Tb_BahanbakarController@index');	
	Route::get('tb_bahanbakar/view/{rec_id}', 'Tb_BahanbakarController@view');	
	Route::post('tb_bahanbakar/add', 'Tb_BahanbakarController@add');	
	Route::any('tb_bahanbakar/edit/{rec_id}', 'Tb_BahanbakarController@edit');	
	Route::any('tb_bahanbakar/delete/{rec_id}', 'Tb_BahanbakarController@delete');

/* routes for Track Controller  */	
	Route::get('track', 'TrackController@index');
	Route::get('track/index', 'TrackController@index');
	Route::get('track/index/{filter?}/{filtervalue?}', 'TrackController@index');	
	Route::get('track/view/{rec_id}', 'TrackController@view');	
	Route::any('track/edit/{rec_id}', 'TrackController@edit');	
	Route::any('track/delete/{rec_id}', 'TrackController@delete');

/* routes for Users Controller  */	
	Route::get('users', 'UsersController@index');
	Route::get('users/index', 'UsersController@index');
	Route::get('users/index/{filter?}/{filtervalue?}', 'UsersController@index');	
	Route::get('users/view/{rec_id}', 'UsersController@view');	
	Route::any('account/edit', 'AccountController@edit');	
	Route::get('account', 'AccountController@index');	
	Route::post('account/changepassword', 'AccountController@changepassword');	
	Route::get('account/currentuserdata', 'AccountController@currentuserdata');	
	Route::post('users/add', 'UsersController@add');	
	Route::any('users/edit/{rec_id}', 'UsersController@edit');	
	Route::any('users/delete/{rec_id}', 'UsersController@delete');

/* routes for Voucher Controller  */	
	Route::get('voucher', 'VoucherController@index');
	Route::get('voucher/index', 'VoucherController@index');
	Route::get('voucher/index/{filter?}/{filtervalue?}', 'VoucherController@index');	
	Route::get('voucher/view/{rec_id}', 'VoucherController@view');	
	Route::post('voucher/add', 'VoucherController@add');	
	Route::any('voucher/edit/{rec_id}', 'VoucherController@edit');	
	Route::any('voucher/delete/{rec_id}', 'VoucherController@delete');

});

Route::get('home', 'HomeController@index');
	
	Route::post('auth/login', 'AuthController@login');
	Route::get('login', 'AuthController@login')->name('login');
		
	Route::post('auth/forgotpassword', 'AuthController@forgotpassword')->name('password.reset');	
	Route::post('auth/resetpassword', 'AuthController@resetpassword');
	
	Route::get('components_data/jenis_kendaraan_option_list/{arg1?}', 'Components_dataController@jenis_kendaraan_option_list');	
	Route::get('components_data/users_name_exist/{arg1?}', 'Components_dataController@users_name_exist');	
	Route::get('components_data/users_email_exist/{arg1?}', 'Components_dataController@users_email_exist');	
	Route::get('components_data/jenis_bbm_option_list/{arg1?}', 'Components_dataController@jenis_bbm_option_list');	
	Route::get('components_data/barchart_datapemintapengajuanvoucher/{arg1?}', 'Components_dataController@barchart_datapemintapengajuanvoucher');	
	Route::get('components_data/barchart_datavoucherpengisianbbm/{arg1?}', 'Components_dataController@barchart_datavoucherpengisianbbm');	
	Route::get('components_data/barchart_datapengajuanvoucher/{arg1?}', 'Components_dataController@barchart_datapengajuanvoucher');	
	Route::get('components_data/barchart_datajumlahliterperkilometer/{arg1?}', 'Components_dataController@barchart_datajumlahliterperkilometer');	
	Route::get('components_data/barchart_datatotalpengisianbbm/{arg1?}', 'Components_dataController@barchart_datatotalpengisianbbm');


/* routes for FileUpload Controller  */	
Route::post('fileuploader/upload/{fieldname}', 'FileUploaderController@upload');
Route::post('fileuploader/s3upload/{fieldname}', 'FileUploaderController@s3upload');
Route::post('fileuploader/remove_temp_file', 'FileUploaderController@remove_temp_file');