<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\GaleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\Logincontroller;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PenghargaanController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PromosiController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\StrukturController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\SatuanController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->group(function () {
    Route::post('login', [Logincontroller::class, 'authenticate'])->name('login');
});
Route::group(['middleware' => ['jwt.verify', 'cors']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('/');
    Route::prefix('api/v1')->group(function () {
        Route::post('getdata', [UserLevelController::class, 'getuserdata'])->name('insert');
        Route::prefix('disposisi')->group(function () {
            Route::get('currentdisposisi', [DisposisiController::class, 'getcurrentdisposisi'])->name('getcurrent');
            Route::get('list', [DisposisiController::class, 'index'])->name('list');
            Route::post('insert', [DisposisiController::class, 'store'])->name('insert');
            Route::get('detail/{id}', [DisposisiController::class, 'edit'])->name('detail');
            Route::post('update/{id}', [DisposisiController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [DisposisiController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('surat')->group(function () {
            Route::get('list', [SuratController::class, 'index'])->name('list');
            Route::post('insert', [SuratController::class, 'store'])->name('insert');
            Route::get('detail/{id}', [SuratController::class, 'edit'])->name('detail');
            Route::post('update/{id}', [SuratController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [SuratController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('surat_keluar')->group(function () {
            Route::get('list', [SuratKeluarController::class, 'index'])->name('list');
            Route::post('insert', [SuratKeluarController::class, 'store'])->name('insert');
            Route::get('detail/{id}', [SuratKeluarController::class, 'edit'])->name('detail');
            Route::post('update/{id}', [SuratKeluarController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [SuratKeluarController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('jenisarsip')->group(function () {
            Route::get('list', [JenisController::class, 'index'])->name('list');
            Route::post('insert', [JenisController::class, 'store'])->name('insert');
            Route::get('detail/{id}', [JenisController::class, 'edit'])->name('detail');
            Route::post('update/{id}', [JenisController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [JenisController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('getmaster')->group(function () {
            Route::post('jenis', [JenisController::class, 'JenisMaster'])->name('jenis');
            Route::post('satuan', [JenisController::class, 'masterSatuan'])->name('satuan');
        });
        Route::prefix('pegawai')->group(function () {
            Route::get('list', [PegawaiController::class, 'index'])->name('list');
            Route::post('insert', [PegawaiController::class, 'store'])->name('insert');
            Route::get('detail/{id}', [PegawaiController::class, 'edit'])->name('detail');
            Route::post('update/{id}', [PegawaiController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [PegawaiController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('arsip')->group(function () {
            Route::get('list', [ArsipController::class, 'index'])->name('list');
            Route::post('insert', [ArsipController::class, 'store'])->name('insert');
            Route::get('detail/{id}', [ArsipController::class, 'edit'])->name('detail');
            Route::post('update/{id}', [ArsipController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [ArsipController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('report')->group(function () {
            Route::post('datareportsurat', [SuratController::class, 'datareportsurat'])->name('datareportsurat');
            Route::post('diposisi', [SuratController::class, 'reportDisposisi'])->name('disposisi');
        });
        Route::prefix('satuan')->group(function () {
            Route::get('list', [SatuanController::class, 'list'])->name('list');
            Route::post('insert', [SatuanController::class, 'store'])->name('insert');
            Route::get('detail/{id}', [SatuanController::class, 'edit'])->name('detail');
            Route::post('update/{id}', [SatuanController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [SatuanController::class, 'destroy'])->name('destroy');
        });
        Route::post('getuser', [Logincontroller::class, 'get_user'])->name('getuser');
        Route::post('logout', [Logincontroller::class, 'logout'])->name('logout');
        Route::get('penghargaan', [HomeController::class, 'penghargaan'])->name('penghargaan');
        Route::post('artikel', [HomeController::class, 'filterPosts'])->name('artikel');
        Route::post('listpromo', [HomeController::class, 'filterPromo'])->name('listpromo');
        Route::post('listvideo', [HomeController::class, 'filterVideo'])->name('listvideo');
        Route::get('newsupdate', [HomeController::class, 'newsupdate'])->name('newsupdate');
        Route::get('currentPromosi', [HomeController::class, 'currentPromosi'])->name('currentPromosi');
        Route::get('artikelBycategory', [HomeController::class, 'filterPostsBycat'])->name('artikelBycategory');
        Route::get('galery', [HomeController::class, 'filterGalery'])->name('galery');
        Route::get('event', [HomeController::class, 'filterEvent'])->name('event');
        Route::get('search', [HomeController::class, 'searchPost'])->name('search');
        Route::get('newgalery', [HomeController::class, 'filterNewGalery'])->name('newgalery');
        Route::get('randomPromo', [HomeController::class, 'randomPromo'])->name('randomPromo');
        Route::get('detailpromo/{id}', [HomeController::class, 'promoshow'])->name('detailpromo');
        Route::get('jadwalEdukasi', [HomeController::class, 'jadwalEdukasi'])->name('jadwalEdukasi');
        // market info
        Route::get('currency', [HomeController::class, 'currency'])->name('currency');
        Route::get('risetcat', [HomeController::class, 'getCategoryris'])->name('risetcat');
        Route::get('manajemen', [HomeController::class, 'manajemen'])->name('manajemen');
        Route::get('manajemen/{id}', [HomeController::class, 'manajemen'])->name('manajemen');
    });
});
Route::group(['middleware' => ['jwt.verify', 'cors']], function () {

    Route::prefix('api/v1')->group(function () {
        Route::get('paramdashboard/{id}', [HomeController::class, 'paramdashboard'])->name('paramdashboard');
        Route::prefix('aplication')->group(function () {
            Route::post('upload', [HomeController::class, 'upload'])->name('upload');
            Route::post('filemanager', [HomeController::class, 'filemanager'])->name('filemanager');
        });
        Route::prefix('riset')->group(function () {
            Route::post('list', [PostController::class, 'listriset'])->name('list');
        });
        Route::prefix('artikel')->group(function () {
            Route::get('categoryartikel', [PostController::class, 'categoryartikel'])->name('categoryartikel');
            Route::post('list', [PostController::class, 'index'])->name('list');
            Route::get('edit/{id}', [PostController::class, 'edit'])->name('list');
            Route::post('insert', [PostController::class, 'store'])->name('insert');
            Route::post('update/{id}', [PostController::class, 'update'])->name('update');
            Route::post('active', [PostController::class, 'actived'])->name('active');
            Route::delete('destroy/{id}', [PostController::class, 'destroy'])->name('destroy');
        }); 
        Route::prefix('pengajuan_arsip')->group(function () {
            Route::post('list', [PengajuanController::class, 'index'])->name('list');
            Route::post('insert', [PengajuanController::class, 'store'])->name('insert');
            Route::post('update/{id}', [PengajuanController::class, 'update'])->name('update');
            Route::post('active', [PengajuanController::class, 'actived'])->name('active');
            Route::delete('destroy/{id}', [PengajuanController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('statistik')->group(function () {
            Route::get('list', [StatistikController::class, 'index'])->name('list');
            Route::post('insert', [StatistikController::class, 'store'])->name('insert');
            Route::get('edit/{id}', [StatistikController::class, 'edit'])->name('detail');
            Route::post('update/{id}', [StatistikController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [StatistikController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('halaman')->group(function () {
            Route::get('list', [PagesController::class, 'index'])->name('list');
            Route::post('insert', [PagesController::class, 'store'])->name('insert');
            Route::get('detail/{id}', [PagesController::class, 'edit'])->name('detail');
            Route::post('update/{id}', [PagesController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [PagesController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('struktur')->group(function () {
            Route::get('list', [StrukturController::class, 'index'])->name('list');
            Route::post('insert', [StrukturController::class, 'store'])->name('insert');
            Route::get('detail/{id}', [StrukturController::class, 'edit'])->name('detail');
            Route::post('update/{id}', [StrukturController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [StrukturController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('kategori')->group(function () {
            Route::get('list', [CategoryController::class, 'index'])->name('list');
            Route::post('insert', [CategoryController::class, 'store'])->name('insert');
            Route::put('update/{id}', [CategoryController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('level')->group(function () {
            Route::post('list', [UserLevelController::class, 'index'])->name('list');
            Route::post('insert', [UserLevelController::class, 'store'])->name('insert');
            Route::get('edit/{id}', [UserLevelController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [UserLevelController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [UserLevelController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('tags')->group(function () {
            Route::get('list', [TagsController::class, 'index'])->name('list');
            Route::get('edit/{id}', [TagsController::class, 'edit'])->name('edit');
            Route::post('insert', [TagsController::class, 'store'])->name('insert');
            Route::post('update/{id}', [TagsController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [TagsController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('download')->group(function () {
            Route::get('list', [DownloadController::class, 'index'])->name('list');
            Route::post('insert', [DownloadController::class, 'store'])->name('insert');
            Route::get('edit/{id}', [DownloadController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [DownloadController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [DownloadController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('video')->group(function () {
            Route::get('list', [VideoController::class, 'index'])->name('list');
            Route::get('show/{id}', [VideoController::class, 'show'])->name('show');
            Route::post('insert', [VideoController::class, 'store'])->name('insert');
            Route::post('update/{id}', [VideoController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [VideoController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('category')->group(function () {
            Route::get('list', [CategoryController::class, 'index'])->name('list');
            Route::post('insert', [CategoryController::class, 'store'])->name('insert');
            Route::post('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [CategoryController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('album')->group(function () {
            Route::get('list', [AlbumController::class, 'index'])->name('list');
            Route::post('insert', [AlbumController::class, 'store'])->name('insert');
            Route::get('edit/{id}', [AlbumController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [AlbumController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [AlbumController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('award')->group(function () {
            Route::get('list', [PenghargaanController::class, 'index'])->name('list');
            Route::post('insert', [PenghargaanController::class, 'store'])->name('insert');
            Route::post('update/{id}', [PenghargaanController::class, 'update'])->name('update');
            Route::get('edit/{id}', [PenghargaanController::class, 'edit'])->name('show');
            Route::delete('destroy/{id}', [PenghargaanController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('galery')->group(function () {
            Route::get('list', [GaleryController::class, 'index'])->name('list');
            Route::post('insert', [GaleryController::class, 'store'])->name('insert');
            Route::get('edit/{id}', [GaleryController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [GaleryController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [GaleryController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('tags')->group(function () {
            Route::get('list', [TagsController::class, 'index'])->name('list');
            Route::post('insert', [TagsController::class, 'store'])->name('insert');
            Route::put('update/{id}', [TagsController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [TagsController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('promo')->group(function () {
            Route::get('list', [PromosiController::class, 'index'])->name('list');
            Route::post('insert', [PromosiController::class, 'store'])->name('insert');
            Route::post('action', [PromosiController::class, 'action'])->name('action');
            Route::post('update/{id}', [PromosiController::class, 'update'])->name('update');
            Route::get('edit/{id}', [PromosiController::class, 'edit'])->name('edit');
            Route::delete('destroy/{id}', [PromosiController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('jadwal')->group(function () {
            Route::get('list', [JadwalController::class, 'index'])->name('list');
            Route::get('edit/{id}', [JadwalController::class, 'edit'])->name('edit');
            Route::post('insert', [JadwalController::class, 'store'])->name('insert');
            Route::post('update/{id}', [JadwalController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [JadwalController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('user')->group(function () {
            Route::post('list', [UsersController::class, 'index'])->name('list');
            Route::post('insert', [UsersController::class, 'store'])->name('insert');
            Route::post('edit/{id}', [UsersController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [UsersController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [UsersController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('slider')->group(function () {
            Route::get('list', [SliderController::class, 'index'])->name('list');
            Route::post('insert', [SliderController::class, 'store'])->name('insert');
            Route::post('actived', [SliderController::class, 'actived'])->name('edit');

            Route::post('edit/{id}', [SliderController::class, 'edit'])->name('edit');
            Route::post('slider/{id}', [SliderController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [SliderController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [SliderController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('agenda')->group(function () {
            Route::post('list', [EventsController::class, 'index'])->name('list');
            Route::post('insert', [EventsController::class, 'insert'])->name('insert');
            Route::post('edit/{id}', [EventsController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [EventsController::class, 'update'])->name('update');
            Route::post('destroy', [EventsController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('laporan')->group(function () {
            Route::get('list', [LaporanController::class, 'index'])->name('list');
            Route::post('insert', [LaporanController::class, 'store'])->name('insert');
            Route::post('edit/{id}', [LaporanController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [LaporanController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [LaporanController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('cabang')->group(function () {
            Route::post('list', [CabangController::class, 'index'])->name('list');
            Route::post('insert', [CabangController::class, 'store'])->name('insert');
            Route::post('edit/{id}', [CabangController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [CabangController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [CabangController::class, 'destroy'])->name('destroy');
        });
    });
});
