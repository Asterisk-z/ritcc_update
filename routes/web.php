<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FMDQ\InstitutionController;
use App\Http\Controllers\FMDQ\IQXController;
use App\Http\Controllers\FMDQ\ProfileController;
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

Route::get('/testing', function () {
    dd('testing');
});

// Auth
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('/sign-in', [LoginController::class, 'signIn'])->name('signIn');
Route::post('/sign-out', [LoginController::class, 'signOut'])->name('signOut');

// dashboard

Route::middleware(['auth'])->group(function () {
    //
    Route::middleware(['isSuperUser'])->group(function () {

        Route::get('/iqx-dashboard', [IQXController::class, 'index'])->name('iqx.dashboard');
    });
    //
    Route::middleware(['isSuperUser', 'isInputter'])->group(function () {

        Route::get('/profile-management', [ProfileController::class, 'index'])->name('profile.index');

        Route::get('/institution-management', [InstitutionController::class, 'index'])->name('institution.index');
        Route::get('/institution-management/pending', [InstitutionController::class, 'pending'])->name('institution.pending');
        Route::get('/institution-management/rejected', [InstitutionController::class, 'rejected'])->name('institution.rejected');
        Route::get('/institution-management/approved', [InstitutionController::class, 'approved'])->name('institution.approved');
        Route::post('/institution/create', [InstitutionController::class, 'create'])->name('institution.create');
        Route::post('/institution/update/{id}', [InstitutionController::class, 'update'])->name('institution.update');
        Route::post('/institution/delete/{id}', [InstitutionController::class, 'delete'])->name('institution.delete');

        Route::post('/institution/create/approve/{id}', [InstitutionController::class, 'approveCreate'])->name('institution.approveCreate');
        Route::post('/institution/create/reject/{id}', [InstitutionController::class, 'rejectCreate'])->name('institution.rejectCreate');
    });
    // authoriser
    Route::middleware(['isSuperUser', 'isAuthoriser'])->group(function () {

        Route::get('/profile-management', [ProfileController::class, 'index'])->name('profile.index');

        Route::get('/institution-management', [InstitutionController::class, 'index'])->name('institution.index');
        Route::get('/institution-management/pending', [InstitutionController::class, 'pending'])->name('institution.pending');
        Route::get('/institution-management/rejected', [InstitutionController::class, 'rejected'])->name('institution.rejected');
        Route::get('/institution-management/approved', [InstitutionController::class, 'approved'])->name('institution.approved');
        Route::post('/institution/create', [InstitutionController::class, 'create'])->name('institution.create');
        Route::post('/institution/update/{id}', [InstitutionController::class, 'update'])->name('institution.update');
        Route::post('/institution/delete/{id}', [InstitutionController::class, 'delete'])->name('institution.delete');

        Route::post('/institution/create/approve/{id}', [InstitutionController::class, 'approveCreate'])->name('institution.approveCreate');
        Route::post('/institution/create/reject/{id}', [InstitutionController::class, 'rejectCreate'])->name('institution.rejectCreate');
    });
    // auctioneer
    // bidder
    Route::middleware(['isAuctioneer', 'isBidder'])->group(function () {

        Route::get('/auction-management', [IQXController::class, 'index'])->name('auction.dashboard');
    });
});
