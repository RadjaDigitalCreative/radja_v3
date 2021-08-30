<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

// api akses
Route::get('version', 'Api\Akses@ver')->name('api.akses');
Route::get('akses', 'Api\Akses@index')->name('api.akses');
Route::get('akses/{id}', 'Api\Akses@edit')->name('api.akses');
Route::post('akses', 'Api\Akses@create')->name('api.akses');
Route::put('akses/{id}', 'Api\Akses@update')->name('api.akses');
Route::delete('akses/{id}', 'Api\Akses@delete')->name('api.akses');

// api supplier
Route::post('supplier', 'Api\Supplier@index')->name('api.supplier');
Route::get('supplier/{id}', 'Api\Supplier@edit')->name('api.supplier');
Route::post('supplier/create', 'Api\Supplier@create')->name('api.supplier');
Route::put('supplier/{id}', 'Api\Supplier@update')->name('api.supplier');
Route::delete('supplier/{id}', 'Api\Supplier@delete')->name('api.supplier');

// api produk
Route::post('category', 'Api\Category@index')->name('api.category');
Route::get('category/{id}', 'Api\Category@edit')->name('api.category');
Route::post('category/create', 'Api\Category@create')->name('api.category');
Route::put('category/{id}', 'Api\Category@update')->name('api.category');
Route::delete('category/{id}', 'Api\Category@delete')->name('api.category');

// api cabang
Route::post('cabang', 'Api\Cabang@index')->name('api.cabang');
Route::get('cabang/{id}', 'Api\Cabang@edit')->name('api.cabang');
Route::post('cabang/create', 'Api\Cabang@create')->name('api.cabang');
Route::put('cabang/{id}', 'Api\Cabang@update')->name('api.cabang');
Route::delete('cabang/{id}', 'Api\Cabang@delete')->name('api.cabang');

// api payment
Route::post('payment', 'Api\Payment@index')->name('api.payment');
Route::get('payment/{id}', 'Api\Payment@edit')->name('api.payment');
Route::post('payment/create', 'Api\Payment@create')->name('api.payment');
Route::put('payment/{id}', 'Api\Payment@update')->name('api.payment');
Route::delete('payment/{id}', 'Api\Payment@delete')->name('api.payment');

// api product
Route::get('contoh_product', 'Api\Product@contoh_product')->name('api.contoh_product');

Route::post('product', 'Api\Product@index')->name('api.product');
Route::post('product/export', 'Api\Product@export')->name('api.product.export');
Route::post('product/import', 'Api\Product@import')->name('api.product.import');
Route::get('product/record/{id}', 'Api\Product@record')->name('api.product.record');
Route::get('product/{id}', 'Api\Product@edit')->name('api.product');
Route::post('product/create', 'Api\Product@create')->name('api.product');
Route::post('product/update/{id}', 'Api\Product@update')->name('api.product');
Route::post('product/update/no_grosir/{id}', 'Api\Product@update_no_grosir')->name('api.product');
Route::post('product/update/add_grosir/{id}', 'Api\Product@update_add_grosir')->name('api.product');
Route::post('product/update/delete_grosir/{id}', 'Api\Product@update_delete_grosir')->name('api.product');
Route::delete('product/{id}', 'Api\Product@delete')->name('api.product');

// api order
Route::post('order', 'Api\Order@index')->name('api.order');
Route::get('order/{id}', 'Api\Order@edit')->name('api.order');
Route::post('order/create', 'Api\Order@create')->name('api.order');
Route::put('order/{id}', 'Api\Order@update')->name('api.order');
Route::delete('order/{id}', 'Api\Order@delete')->name('api.order');
Route::get('order/invoice/{id}', 'Api\Order@invoice')->name('api.order');
Route::get('order/print/{id}', 'Api\Order@print')->name('api.order');
Route::get('order/printpdf/{id}', 'Api\Order@printpdf')->name('api.order');

// api kas
Route::post('kas', 'Api\Kas@index')->name('api.kas');
Route::get('kas/export', 'Api\Kas@export')->name('api.kas.export');
Route::get('kas/{id}', 'Api\Kas@edit')->name('api.kas');
Route::post('kas/uang_keluar', 'Api\Kas@uang_keluar')->name('api.uang_keluar');
Route::post('kas/masuk', 'Api\Kas@uang_masuk')->name('api.uang_masuk');
Route::delete('kas/delete/{id}', 'Api\Kas@delete')->name('api.kas');
Route::get('kas/invoice/{id}', 'Api\Kas@invoice')->name('api.order');

// api restock
Route::post('restock', 'Api\Restock@index')->name('api.restock');
Route::get('restock/{id}', 'Api\Restock@edit')->name('api.restock');
Route::post('restock/create', 'Api\Restock@create')->name('api.restock');
Route::post('restock/konfirmasi/{id}', 'Api\Restock@konfirmasi')->name('api.restock');
Route::put('restock/{id}', 'Api\Restock@update')->name('api.restock');
Route::delete('restock/{id}', 'Api\Restock@delete')->name('api.restock');

// all api
Route::get('all', 'Api\All@index')->name('api.all');
Route::get('all/{id}', 'Api\All@edit')->name('api.all');
Route::post('all', 'Api\All@create')->name('api.all');
Route::put('all/{id}', 'Api\All@update')->name('api.all');
Route::delete('all/{id}', 'Api\All@delete')->name('api.all');

// api report
Route::put('report', 'Api\Report@index')->name('api.report');
Route::put('grade', 'Api\Report@grade')->name('api.report');
Route::put('laba', 'Api\Report@laba')->name('api.report');

Route::post('report/export', 'Api\Report@report_export')->name('api.report');
Route::post('report/grade/export', 'Api\Report@report_grade_export')->name('api.report');
Route::get('report/laba/export', 'Api\Report@export')->name('api.laba.export');
Route::get('report/{id}', 'Api\Report@edit')->name('api.report');
Route::post('report', 'Api\Report@create')->name('api.report');
Route::put('report/{id}', 'Api\Report@update')->name('api.report');
Route::delete('report/{id}', 'Api\Report@delete')->name('api.report');

// api report pembeli
Route::post('pembeli', 'Api\Pembeli@index')->name('api.pembeli');
Route::get('pembeli/export', 'Api\Pembeli@export')->name('api.pembeli.export');
Route::get('pembeli/{id}', 'Api\Pembeli@edit')->name('api.pembeli');

// api login dan register
Route::post('login', 'Api\Login@login')->name('api.login');
Route::post('reset/password', 'Api\Forgot@forgot')->name('api.login');
Route::group(['middleware' => ['web']], function () {
    Route::get('google/login', 'Api\Login@google')->name('api.login');
});

Route::post('logout', 'Api\Login@logout')->name('api.logout');
Route::post('register', 'Api\Login@register')->name('api.register');
Route::get('email/verify/{id}/{hash}', 'Api\Login@verify')->name('verification.verify');
Route::get('users', 'Api\Login@user')->name('api.user');
Route::get('users/{id}', 'Api\Login@user_id')->name('api.user');
Route::post('users/status', 'Api\Login@status')->name('api.user');
Route::get('users/rekap/pembayaran', 'Api\Login@rekap_pembayaran')->name('api.user');
Route::get('harga', 'Api\Harga@list_harga')->name('api.harga');
Route::post('bayar', 'Api\Harga@bayar')->name('api.harga');
Route::post('user/status', 'Api\Harga@user_status')->name('api.harga');
Route::get('notif/konfirmasi', 'Api\Harga@notif_konfirmasi')->name('api.harga');
Route::post('konfirmasi/status', 'Api\Harga@approve_konfirmasi')->name('api.harga');
Route::post('maps/update', 'Api\Login@maps_update')->name('api.maps');
Route::post('maps', 'Api\Login@maps')->name('api.maps');

// route wa list send broo
Route::post('wa', 'Api\Waweb@index')->name('api.waweb');
Route::post('wa/konfirmasi', 'Api\Waweb@konfirmasi')->name('api.waweb');
Route::post('wa/import', 'Api\Waweb@import')->name('api.waweb.import');
Route::get('contoh_wa', 'Api\Waweb@contoh_wa')->name('api.contoh_wa');

 // ABSENSI
Route::post('/absensi', 'Api\Absensi@index')->name('absensi.index');
Route::post('/absensi/rekap', 'Api\Absensi@rekap')->name('absensi.index');
Route::post('/absensi/sudah', 'Api\Absensi@sudah_absen')->name('absensi.index');
Route::post('/absensi/sudah/hari', 'Api\Absensi@sudah_absen_hari')->name('absensi.index');
Route::post('/absensi/all', 'Api\Absensi@absen_all')->name('absensi.index');
Route::post('/absensi/kirim', 'Api\Absensi@kirim')->name('absensi.index');
Route::post('/absensi_lembur/kirim', 'Api\Absensi@absensi_lembur')->name('absensi.index');


// ROLE
Route::post('role', 'Api\Akses@index')->name('api.akses');
Route::post('role/update', 'Api\Akses@update')->name('api.akses');

// GAJi
Route::post('/gaji/norek', 'Api\Gaji@norek')->name('absensi.norek');
Route::post('/gaji/{id}', 'Api\Gaji@index')->name('absensi.index');

// produk laris
Route::post('/terlaris', 'Api\Report@terlaris')->name('absensi.index');

// notif
Route::get('/notif', 'Api\Payment@notif')->name('absensi.index');
Route::post('/notif/hapus', 'Api\Payment@hapus')->name('image.index');

Route::post('/upload/image', 'Api\Image@index')->name('image.index');

// qc
Route::post('/qc/all', 'Api\QC@index')->name('qc.index');
Route::post('/qc/get', 'Api\QC@get')->name('qc.index');

// cuti
Route::post('/cuti', 'Api\Cuti@index');
Route::post('/cuti/user', 'Api\Cuti@user');
Route::post('/cuti/ajukan', 'Api\Cuti@ajukan');
Route::post('/cuti/ajukan/delete', 'Api\Cuti@delete_ajukan');
Route::post('/cuti/bonus', 'Api\Cuti@bonus');
Route::post('/cuti/approve', 'Api\Cuti@approve');
Route::post('/cuti/unapprove', 'Api\Cuti@unapprove');

//jenis_penjualan
Route::post('/jenis_penjualan', 'Api\Product@jenis_penjualan');
Route::post('/jenis_penjualan/create', 'Api\Product@jenis_penjualan_create');
Route::post('/jenis_penjualan/delete', 'Api\Product@jenis_penjualan_delete');
Route::post('/order/jenis_penjualan', 'Api\Order@jenis_penjualan');
Route::post('/report/jenis_penjualan', 'Api\Report@jenis_penjualan');
Route::post('/laba/jenis_penjualan', 'Api\Report@laba_jenis_penjualan');
Route::post('/kas/jenis_penjualan', 'Api\Kas@jenis_penjualan');
