<?php

Route::get('/', 'Admin\AuthController@index')->name('auth.index');
Route::get('/logout', 'Admin\AuthController@logout')->name('log.logout');
Auth::routes(['verify' => true]);

//verifikasi email user
// verifikasi otp

//Sosmed
Route::get('auth/google', 'Auth\GoogleController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\GoogleController@handleGoogleCallback');
Route::get('redirect/{driver}', 'Auth\LoginController@redirectToProvider')->name('login.provider');
Route::get('auth/{provider}/callback', 'Auth\SocialController@handleProviderCallback');

Route::get('auth/referal/{id}', 'Auth\RegisterController@referal');
Route::get('/verifymenu', 'Auth\GoogleController@verifymenu');
Route::post('/verifymenu/store', 'Auth\GoogleController@verifymenu_store')->name('verifymenu.store');
Route::get('/verifymenu/check/{id}', 'Auth\GoogleController@verifymenu_check')->name('verifymenu.check');
Route::group(['middleware' => 'verified', 'auth'], function () {
    Route::prefix('admin')->group(function () {

        // Notif
        Route::get('/notif', 'Admin\NotifController@index')->name('notif');

        //Master
        Route::get('/', 'Admin\HomeController@index');
        Route::get('/category/table', 'Admin\CategoryController@table')->name('category.table');
        Route::get('/harga_grosir/delete/{id}', 'Admin\ProductController@harga_grosir_delete')->name('harga_grosir.delete');

        //    item jenis penjualan
        Route::get('/item/jenis/penjualan', 'Admin\ProductController@jenis_penjualan')->name('item.jenis.penjualan');
        Route::get('/item/jenis/penjualan/create', 'Admin\ProductController@jenis_penjualan_create')->name('item.jenis.penjualan.create');
        Route::post('/item/jenis/penjualan/store', 'Admin\ProductController@jenis_penjualan_store')->name('item.jenis.penjualan.store');
        Route::delete('/item/jenis/penjualan/delete/{id}', 'Admin\ProductController@jenis_penjualan_delete')->name('item.jenis.penjualan.delete');
//        order_jenis_penjualan
        Route::get('/order/filter', 'Admin\OrderController@filter')->name('order.filter');
        Route::get('/laba/filter', 'Admin\LabaController@filter')->name('laba.filter');
        Route::get('/report/filter', 'Admin\ReportController@filter')->name('report.filter');
        Route::get('/kas/filter', 'Admin\KasController@filter')->name('kas.filter');

//        is_sales
        Route::post('/sales', 'Admin\UserController@is_sales')->name('users.sales');

        // Route::resource('/profile', 'Admin\ProfileController');
        Route::resource('/category', 'Admin\CategoryController');
        Route::resource('/akses', 'Admin\AksesController');
        Route::resource('/item', 'Admin\ProductController');
        Route::resource('/supplier', 'Admin\SupplierController');
        Route::resource('/order', 'Admin\OrderController');
        Route::resource('/payment', 'Admin\PaymentController');
        Route::resource('/user', 'Admin\UserController');
        Route::resource('/cabang', 'Admin\CabangController');
        Route::resource('/credit', 'Admin\CreditController');
        Route::resource('/role', 'Admin\RoleController');
        Route::resource('/kas', 'Admin\KasController');
        Route::resource('/transfer', 'Admin\TransferController');
        Route::resource('/waweb', 'Admin\WaWebController');
        Route::resource('/laba', 'Admin\LabaController');
        Route::post('/email/{id}', 'Admin\OrderController@sendmail')->name('order.mail');

        // about
        Route::get('/about', 'Admin\AboutController@index')->name('about.index');
        Route::post('/users/filter', 'Admin\UserController@filter')->name('users.filter');

        // Data Profile
        Route::get('/profile', 'Admin\ProfileController@index')->name('profile.index');
        Route::get('/profile/edit', 'Admin\ProfileController@edit')->name('profile.edit');
        Route::post('/profile/edit/store', 'Admin\ProfileController@store')->name('profile.edit.store');
        Route::post('/profile/image/store', 'Admin\ProfileController@image_store')->name('profile.image.store');

        // Data Record
        Route::get('/record/masuk', 'Admin\RecordController@masuk')->name('record.masuk');
        Route::get('/record/keluar', 'Admin\RecordController@keluar')->name('record.keluar');

        // Data Agen satu
        Route::get('/referal', 'Admin\AgenController@referal')->name('agen.referal');
        Route::get('/agen', 'Admin\AgenController@index')->name('agen');
        Route::get('/agen2', 'Admin\AgenController@index2')->name('agen.dua');
        Route::get('/agen3', 'Admin\AgenController@index3')->name('agen.tiga');
        Route::get('/agen/bonus', 'Admin\AgenController@bonus')->name('agen.bonus');
        Route::get('/agen/bonus2', 'Admin\AgenController@bonus2')->name('agen.bonus2');
        Route::get('/agen/bonus3', 'Admin\AgenController@bonus3')->name('agen.bonus3');
        Route::post('/agen/bonus/upah', 'Admin\AgenController@upah')->name('agen.upah');
        Route::post('/agen/bonus/upah2', 'Admin\AgenController@upah2')->name('agen.upah2');
        Route::post('/agen/bonus/upah3', 'Admin\AgenController@upah3')->name('agen.upah3');
        Route::get('/agen/bonus/list', 'Admin\AgenController@bonus_list')->name('agen.bonus.list');
        Route::get('/agen/bonus/list2', 'Admin\AgenController@bonus_list2')->name('agen.bonus.list2');
        Route::get('/agen/bonus/list3', 'Admin\AgenController@bonus_list3')->name('agen.bonus.list3');
        Route::get('/agen/create', 'Admin\AgenController@create')->name('agen.create');
        Route::get('/agen/createAll', 'Admin\AgenController@createAll')->name('agen.createAll');
        Route::post('/agen/code/generate', 'Admin\AgenController@code_generate')->name('agen.code.generate');
        Route::get('/agen/code/generate/delete/{id}', 'Admin\AgenController@code_delete')->name('agen.code.delete');
        Route::get('/agen/code/generate/deleteAll', 'Admin\AgenController@code_deleteAll')->name('agen.code.deleteAll');

        // Data Agen Kedua
        Route::get('/agen/dua/{id}', 'Admin\AgenController@agen_dua')->name('agen.kedua');
        Route::get('/agen/tiga/{id}', 'Admin\AgenController@agen_tiga')->name('agen.ketiga');


        // Data Semua Orang
        Route::get('/database', 'Admin\DatabaseController@wa')->name('database.index');
        Route::get('/database/pembeli', 'Admin\DatabaseController@pembeli')->name('database.pembeli');
        Route::delete('/database/pembeli/delete/{id}', 'Admin\DatabaseController@destroy')->name('database.pembeli.delete');
        Route::delete('/database/delete/{id}', 'Admin\DatabaseController@destroy2')->name('database.delete');
        Route::get('/database/deleteAll2', 'Admin\DatabaseController@deletePembeliAll')->name('database.pembeli.deleteAll');
        Route::get('/database/deleteAll', 'Admin\DatabaseController@deleteWaAll')->name('database.deleteAll');

        //Jam absensi
        Route::get('/jam/create', 'Admin\PegawaiController@jam')->name('pegawai.jam.create');
        Route::post('/jam/store', 'Admin\PegawaiController@jam_store')->name('pegawai.jam.store');
        Route::get('/jam/edit/{id}', 'Admin\PegawaiController@jam_edit')->name('pegawai.jam.edit');
        Route::post('/jam/update/{id}', 'Admin\PegawaiController@jam_update')->name('pegawai.jam.update');

        // Hari Kerja Pegawai
        Route::get('/pegawai/hari', 'Admin\PegawaiController@hari')->name('pegawai.hari');
        Route::post('/pegawai/filter', 'Admin\PegawaiController@hari_filter')->name('pegawai.hari.filter');
        Route::get('/pegawai/hari/create', 'Admin\PegawaiController@hari_create')->name('pegawai.hari.create');
        Route::post('/pegawai/hari/store', 'Admin\PegawaiController@hari_store')->name('pegawai.hari.store');
        Route::delete('/pegawai/hari/delete{id}', 'Admin\PegawaiController@hari_destroy')->name('pegawai.hari.destroy');
        Route::get('/pegawai/hari/destroyAll', 'Admin\PegawaiController@hari_destroyAll')->name('pegawai.hari.destroyAll');

        // Absensi Kerja Pegawai
        Route::get('/pegawai/absensi', 'Admin\PegawaiController@absensi')->name('pegawai.absensi');
        Route::post('/pegawai/absensi/cuti/status/{id}', 'Admin\PegawaiController@cuti_status')->name('pegawai.absensi.cuti.status');
        Route::post('/pegawai/absensi/status/{id}', 'Admin\PegawaiController@absensi_status')->name('pegawai.absensi.status');
        Route::post('/pegawai/lembur/status/{id}', 'Admin\PegawaiController@absensi_lembur')->name('pegawai.lembur.status');
        Route::post('/pegawai/absensi/filter', 'Admin\PegawaiController@absensi_filter')->name('pegawai.absensi.filter');

        // Gaji Pegawai
        Route::get('/pegawai/gaji', 'Admin\PegawaiController@gaji')->name('pegawai.gaji');
        Route::post('/pegawai/gaji/filter', 'Admin\PegawaiController@gaji_filter')->name('pegawai.gaji.filter');
        Route::get('/pegawai/gaji/create', 'Admin\PegawaiController@gaji_create')->name('pegawai.gaji.create');
        Route::post('/pegawai/gaji/store', 'Admin\PegawaiController@gaji_store')->name('pegawai.gaji.store');
        Route::post('/pegawai/lembur/store', 'Admin\PegawaiController@jam_lembur')->name('pegawai.lembur.store');
        Route::get('/pegawai/gaji/edit{id}', 'Admin\PegawaiController@gaji_edit')->name('pegawai.gaji.edit');
        Route::delete('/pegawai/gaji/destroy/{id}', 'Admin\PegawaiController@gaji_destroy')->name('pegawai.gaji.destroy');
        Route::delete('/pegawai/gaji/destroy2/{id}', 'Admin\PegawaiController@gaji_destroy2')->name('pegawai.gaji.destroy2');

        // Gaji Pegawai
        Route::get('/pegawai/rekap', 'Admin\PegawaiController@rekap')->name('pegawai.rekap');
        Route::get('/pegawai/rekap/view/{id}', 'Admin\PegawaiController@rekap_view')->name('pegawai.rekap.view');
        Route::get('/pegawai/rekap/print/{id}', 'Admin\PegawaiController@rekap_print')->name('pegawai.rekap.print');
        Route::post('/pegawai/rekap/filter', 'Admin\PegawaiController@rekap_filter')->name('pegawai.rekap.filter');

        // harga menu
        Route::get('/harga/menu', 'Admin\AksesController@hargamenu')->name('hargamenu.create');
        Route::get('/menu/harga', 'Admin\UserController@menuharga')->name('menuharga.create');
        Route::delete('/menu/harga/delete/{id}', 'Admin\UserController@menuharga_delete')->name('menuharga.delete');
        Route::post('/menu/harga/store', 'Admin\UserController@menuharga_store')->name('menuharga.store');
        Route::get('/harga/tabel/list', 'Admin\AksesController@hargalist')->name('hargatabel.list');
        Route::get('/harga/tabel/view/{id}', 'Admin\AksesController@hargaview')->name('hargatabel.view');
        Route::post('/harga/menu/store', 'Admin\AksesController@hargamenu_store')->name('hargamenu.store');

        // User Pegawai
        Route::get('/pegawai/user', 'Admin\PegawaiController@user')->name('pegawai.user');
        Route::get('/pegawai/user/view/{id}', 'Admin\PegawaiController@user_view')->name('pegawai.user.view');
        // Master cari data produk
        Route::post('/item/cari', 'Admin\ProductController@cari')->name('product.item.cari');
        Route::post('/cabang/cities', 'Admin\WilayahController@store')->name('cities.store');

        //Master cetak (item)
        Route::get('/item/pdf', 'Admin\ProductController@pdf')->name('product.item.pdf');
        Route::get('/qc/qc', 'Admin\QcController@index')->name('product.item.qc');
        Route::post('/qc/qc/store', 'Admin\QcController@store')->name('product.item.qc.store');
        Route::get('/qc/qc/view/{id}', 'Admin\QcController@show')->name('product.item.qc.view');
        Route::post('/qc/qc/view/store/{id}', 'Admin\QcController@qc_store')->name('product.item.qc.copy.store');
        Route::get('/qc/qc/view/print/{id}', 'Admin\QcController@qc_print')->name('product.item.qc.print');
        Route::get('/item/excel', 'Admin\ProductController@excel')->name('product.item.excel');
        Route::get('/item/download', 'Admin\ProductController@download')->name('product.item.download');

        // Master kas
        Route::resource('/kas', 'Admin\KasController');
        Route::resource('/request/kas', 'Admin\KasController');
        // Route::get('/order/laba', 'Admin\OrderController@laba')->name('order.laba');


        // Master request
        Route::resource('/restock', 'Admin\RestockController');
        Route::patch('/restock/{id}/status', 'Admin\RestockController@status')->name('restock.status');
        Route::patch('/restock/{id}/stock', 'Admin\RestockController@stock')->name('restock.stock');
        Route::patch('/restock/{id}/produk', 'Admin\RestockController@produk')->name('restock.produk');
        Route::post('/akses/show', 'Admin\AksesController@show')->name('akses.show');
        Route::post('/restock/create', 'Admin\RestockController@store2')->name('restock.store2');
        Route::patch('/transfer/{id}/konfirmasi', 'Admin\TransferController@konfirmasi')->name('transfer.konfirmasi');
        Route::patch('/transfer/{id}/cancel_konfirmasi', 'Admin\TransferController@cancel_konfirmasi')->name('transfer.cancel_konfirmasi');

        // import barang
        Route::post('import', 'Admin\ProductController@import')->name('item.import');
        Route::post('import/wa', 'Admin\WaWebController@import')->name('wa.import');
        Route::post('send/wa', 'Admin\WaWebController@send')->name('wa.send');
        Route::post('status/wa', 'Admin\WaWebController@status')->name('wa.status');
        Route::get('delete/wa', 'Admin\WaWebController@delete')->name('wa.delete');

        // pembeli
        Route::post('import/pembeli', 'Admin\ReportController@import')->name('pembeli.import');
        Route::get('delete/pembeli', 'Admin\ReportController@delete')->name('pembeli.delete');


        //PDF
        Route::get('/supplier/pdf', 'Admin\SupplierController@pdf')->name('supplier.pdf');
        Route::get('/report', 'Admin\ReportController@index')->name('report.index');
        Route::get('/report/pdf', 'Admin\ReportController@pdf')->name('report.pdf');
        Route::get('/report/excel', 'Admin\ReportController@excel')->name('report.excel');
        Route::get('/report/download', 'Admin\ReportController@download')->name('report.download');
        Route::get('/report/pembeli', 'Admin\ReportController@pembeli')->name('report.pembeli');
        Route::delete('myproductsDeleteAll', 'Admin\ProductController@deleteAll');
        Route::delete('multiplerecordsdelete', 'Admin\ProductController@multiplerecordsdelete');


        // Cuti

        Route::get('/pegawai/cuti', 'Admin\CutiController@index')->name('cuti');
        Route::get('/pegawai/cuti/create', 'Admin\CutiController@create')->name('cuti.create');
        Route::get('/pegawai/cuti/create/ajukan', 'Admin\CutiController@create_ajukan')->name('cuti.ajukan.create');
        Route::post('/pegawai/cuti/store/ajukan', 'Admin\CutiController@store_ajukan')->name('cuti.ajukan.store');
        Route::post('/pegawai/cuti/store', 'Admin\CutiController@store')->name('cuti.store');
        Route::get('/pegawai/cuti/approve/{id}', 'Admin\CutiController@approve')->name('cuti.approve');
        Route::get('/pegawai/cuti/unapprove/{id}', 'Admin\CutiController@unapprove')->name('cuti.unapprove');
        Route::post('/pegawai/cuti/destroy', 'Admin\CutiController@destroy')->name('cuti.destroy');
        Route::post('/pegawai/cuti/nominal', 'Admin\CutiController@nominal')->name('cuti.nominal');
    });

    Route::get('/home', 'Admin\HomeController@index')->name('home');
});
