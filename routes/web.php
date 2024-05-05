<?php

use App\Http\Controllers\CabangController;
use App\Http\Controllers\CatatanMutuController;
use App\Http\Controllers\GroupAccountController;
use App\Http\Controllers\KodeBuktiController;
use App\Http\Controllers\KodePerkiraanController;
use App\Http\Controllers\KunciTransaksiController;
use App\Http\Controllers\PedomanMutuController;
use App\Http\Controllers\ProsesAwalTahunController;
use App\Http\Controllers\ProsesBulananController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('dashboard');
// });

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {
    // Route::get('/', function () {
    //     return view('dashboard');
    // });

    Route::get('/', [KodePerkiraanController::class, 'index']);

    Route::get('home', function () {
        return view('dashboard');
    });

    Route::resource('cabang', CabangController::class);
    Route::resource('proyek', ProyekController::class);
    Route::resource('kodeBukti', KodeBuktiController::class);
    Route::resource('groupAccount', GroupAccountController::class);
    Route::resource('kodePerkiraan', KodePerkiraanController::class);
    Route::resource('user', UserController::class);
    Route::resource('pedomanMutu', PedomanMutuController::class);
    Route::resource('catatanMutu', CatatanMutuController::class);
    Route::resource('kunciTransaksi', KunciTransaksiController::class);

    Route::get('addModalCabang', [CabangController::class, 'addModal'])->name('addModalCabang');
    Route::get('addModalProyek', [ProyekController::class, 'addModal'])->name('addModalProyek');
    Route::get('addModalKodeBukti', [KodeBuktiController::class, 'addModal'])->name('addModalKodeBukti');
    Route::get('addModalGroupAccount', [GroupAccountController::class, 'addModal'])->name('addModalGroupAccount');
    Route::get('addModalKodePerkiraan', [KodePerkiraanController::class, 'addModal'])->name('addModalKodePerkiraan');
    Route::get('viewModalProyekByUser', [UserController::class, 'viewModalProyek'])->name('viewModalProyekByUser');
    Route::get('listProyekByCabang', [KodePerkiraanController::class, 'listProyek'])->name('listProyekByCabang');
    Route::get('listCabangByGroupUser', [UserController::class, 'listCabang'])->name('listCabangByGroupUser');
    Route::get('viewModalResetPwd', [UserController::class, 'viewModalResetPwd'])->name('viewModalResetPwd');
    Route::post('updatePass', [UserController::class, 'updatePass'])->name('updatePass');
    Route::get('viewModalDetailTrx', [TransaksiController::class, 'viewModalDetail'])->name('viewModalDetailTrx');

    Route::get('addModalPedomanMutu', [PedomanMutuController::class, 'addModal'])->name('addModalPedomanMutu');
    Route::get('addModalCatatanMutu', [CatatanMutuController::class, 'addModal'])->name('addModalCatatanMutu');

    Route::get('transJurnal', [TransaksiController::class, 'index'])->name('transJurnal');
    Route::post('transJurnalSearch', [TransaksiController::class, 'search'])->name('transJurnalSearch');
    Route::get('addTransJurnal', [TransaksiController::class, 'create'])->name('addTransJurnal');
    Route::get('addTransJurnalDetail', [TransaksiController::class, 'addModalDetail'])->name('addTransJurnalDetail');
    Route::post('submitTransJurnal', [TransaksiController::class, 'store'])->name('submitTransJurnal');
    Route::get('getNoUrutBuktiByKode', [TransaksiController::class, 'getNoUrutBukti'])->name('getNoUrutBuktiByKode');
    Route::delete('transaksi/{id}/hapusDetailTrx', [TransaksiController::class, 'hapusDetailById'])->name('hapusDetailTrx');
    Route::put('transaksi/{id}', [TransaksiController::class, 'update'])->name('updateTransJurnal');
    Route::get('transaksi/{id}/edit', [TransaksiController::class, 'edit'])->name('editTransJurnal');
    Route::delete('transaksi/{id}/delete', [TransaksiController::class, 'destroy'])->name('deleteTransJurnal');

    Route::get('prosesBulanan', [ProsesBulananController::class, 'index'])->name('prosesBulanan');
    Route::post('submitProsesBulanan', [ProsesBulananController::class, 'proses'])->name('submitProsesBulanan');

    Route::get('prosesAwalTahun', [ProsesAwalTahunController::class, 'index'])->name('prosesAwalTahun');
    Route::post('submitProsesAwalTahun', [ProsesAwalTahunController::class, 'proses'])->name('submitProsesAwalTahun');

    Route::get('addModalKunciTransaksi', [KunciTransaksiController::class, 'addModal'])->name('addModalKunciTransaksi');

    Route::get('saldoAwal', [KodePerkiraanController::class, 'saldoAwal'])->name('saldoAwal');
    Route::post('saldoAwalSearch', [KodePerkiraanController::class, 'saldoAwalSearch'])->name('saldoAwalSearch');
    Route::post('submitSaldoAwal', [KodePerkiraanController::class, 'saldoAwalUpdate'])->name('submitSaldoAwal');

    Route::get('bukuTambahan', [TransaksiController::class, 'bukuTambahan'])->name('bukuTambahan');
    Route::post('bukuTambahanSearch', [TransaksiController::class, 'bukuTambahanSearch'])->name('bukuTambahanSearch');

    Route::get('neraca', [ReportController::class, 'neraca'])->name('neraca');
    Route::post('neracaSearch', [ReportController::class, 'neracaSearch'])->name('neracaSearch');
    Route::get('generalLedger', [ReportController::class, 'generalLedger'])->name('generalLedger');
    Route::post('generalLedgerSearch', [ReportController::class, 'generalLedgerSearch'])->name('generalLedgerSearch');
    Route::get('labaRugi', [ReportController::class, 'labaRugi'])->name('labaRugi');
    Route::post('labaRugiSearch', [ReportController::class, 'labaRugiSearch'])->name('labaRugiSearch');
});
