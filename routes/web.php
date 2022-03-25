<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['role:admin']], function()
{
//User    
Route::resource('/user','UserController');
Route::get('/user/hapus/{id}','UserController@destroy');
Route::post('/user/update/{id}','UserController@update');
//Barang
Route::resource('/barang','BarangController');
Route::get('/barang/hapus/{id}','BarangController@destroy');
Route::get('/barang/edit/{id}','BarangController@edit');
Route::post('/barang/update/{id}','BarangController@update');
//Supplier
Route::resource('/supplier','SupplierController');
Route::get('/supplier/hapus/{id}','SupplierController@destroy');
Route::get('/supplier/edit/{id}','SupplierController@edit');
Route::post('/supplier/update/{id}','SupplierController@update');
//Akun
Route::resource('/akun','AkunController');
Route::get('/akun/hapus/{id}','AkunController@destroy');
Route::get('/akun/edit/{id}','AkunController@edit');
Route::post('/akun/update/{id}','AkunController@update');
//Setting
Route::get('/setting','SettingController@index')->name('setting.transaksi');
Route::post('/setting/simpan','SettingController@simpan');

});

//Pemesanan
Route::get('/transaksi', 'PemesananController@index')->name('pemesanan.transaksi');
Route::post('/sem/store', 'PemesananController@store');
Route::get('/transaksi/hapus/{kd_brg}','PemesananController@destroy');
//Detail Pesan
Route::post('/detail/store', 'DetailPesanController@store');
Route::post('/detail/simpan', 'DetailPesanController@simpan');
//Pembelian
Route::get('/pembelian', 'PembelianController@index')->name('pembelian.transaksi');
Route::get('/cetak/{id}', 'PembelianController@pdf')->name('cetak.order_pdf');
Route::get('/pembelian-beli/{id}', 'PembelianController@edit');
Route::get('/pembelian/hapus/{id}', 'PembelianController@destroy');
Route::post('/pembelian/simpan', 'PembelianController@simpan');
//Retur
Route::get('/retur','ReturController@index')->name('retur.transaksi');
Route::get('/retur-beli/{id}', 'ReturController@edit');
Route::post('/retur/simpan', 'ReturController@simpan');
//Laporan
Route::resource( '/laporan' , 'LaporanController');
Route::resource( '/stok' , 'LapStokController');
//laporan cetak
Route::get('/laporancetak/cetak_pdf', 'LaporanController@cetak_pdf');
