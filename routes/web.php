<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DudiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersertaController;
use App\Http\Controllers\PesertaPklController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\AutoCompleteController;
use App\Http\Controllers\Tahun_ajaranController;
use App\Http\Controllers\KelasController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => true,
    'reset' => false,
    'verify' => false
]);

// Autocomplete
Route::prefix('autocomplete')->group(function () {
    Route::get('/dudi', [AutoCompleteController::class, 'autoCompleteDudi']);
    Route::get('/users', [AutoCompleteController::class, 'autoCompleteUser']);
    Route::get('/peserta', [AutoCompleteController::class, 'autoCompletePeserta']);
    Route::get('/peserta_pkl', [AutoCompleteController::class, 'autoCompletePesertaPKL']);
    Route::get('/kompetensi', [AutoCompleteController::class, 'autoCompleteKompetensi']);
});

// Dashboard & Umum
Route::get('/home/dashboard', [HomeController::class, 'index'])->name('home.dashboard');
Route::get('/home/profil', [HomeController::class, 'profil'])->name('home.profil');
Route::put('/home/profil/update', [HomeController::class, 'update_profil'])->name('home.profil.update');
Route::get('/home/peserta_pkl/export', [PesertaPklController::class, 'export'])->name('peserta_pkl.export');
Route::get('/home/peserta/request_dudi', [PersertaController::class, 'request_dudi'])->name('peserta.request_dudi');
Route::post('/home/peserta/store_request_dudi', [PersertaController::class, 'store_request_dudi'])->name('peserta.store_request_dudi');

// Master Data
Route::resource('/home/tahun_ajaran', Tahun_ajaranController::class);
Route::resource('/home/kelas', KelasController::class);
Route::resource('/home/users', UserController::class);
Route::resource('/home/dudi', DudiController::class);
Route::resource('/home/peserta', PersertaController::class);
Route::resource('/home/peserta_pkl', PesertaPklController::class);
Route::resource('/home/pengaturan', PengaturanController::class)->only('index', 'update');
Route::post('/home/peserta_pkl/import', [PesertaPklController::class, 'import'])->name('peserta_pkl.import');

// Import Data
Route::post('/home/import_dudi', [DudiController::class, 'import'])->name('dudi.import');
Route::post('/home/import_peserta', [PersertaController::class, 'import'])->name('peserta.import');

// User Management
Route::post('/home/users/delete-multiple', [UserController::class, 'deleteMultiple'])->name('users.deleteMultiple');
Route::put('/home/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');

// Surat / Dokumen
Route::get('/home/surat', [SuratController::class, 'index'])->name('home.surat');
Route::get('/home/kop_surat/{id}', [SuratController::class, 'cetakKopSurat'])->name('surat.kop_surat');
Route::get('/home/permohonan/{id}', [SuratController::class, 'cetakPermohonan'])->name('surat.permohonan');
Route::get('/home/pengantar/{id}', [SuratController::class, 'cetakPengantar'])->name('surat.pengantar');
Route::get('/home/penarikan/{id}', [SuratController::class, 'cetakPenarikan'])->name('surat.penarikan');
Route::get('/home/kop-surat-massal', [SuratController::class, 'cetakKopSuratMassal'])->name('surat.kop_surat.massal');
Route::get('/home/permohonan-massal', [SuratController::class, 'cetakPermohonanMassal'])->name('surat.permohonan.massal');
Route::get('/home/pengantar-massal', [SuratController::class, 'cetakPengantarMassal'])->name('surat.pengantar.massal');
Route::get('/home/penarikan-massal', [SuratController::class, 'cetakPenarikanMassal'])->name('surat.penarikan.massal');
