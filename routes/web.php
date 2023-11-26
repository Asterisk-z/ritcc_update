<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FMDQ\AuctionManagementController;
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
    Route::get('/change-password', [LoginController::class, 'changePassword'])->name('changePassword');
    //
    Route::middleware(['isSuperUser'])->group(function () {

        Route::get('/iqx-dashboard', [IQXController::class, 'index'])->name('iqx.dashboard');
        Route::get('/activity-logs', [IQXController::class, 'activityLog'])->name('iqx.logs');

        Route::get('/auction-management', [AuctionManagementController::class, 'index'])->name('auction.mgt.dashboard');
        // profile
        Route::get('/profile-management', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile-management/pending', [ProfileController::class, 'pending'])->name('profile.pending');
        Route::get('/profile-management/rejected', [ProfileController::class, 'rejected'])->name('profile.rejected');
        Route::get('/profile-management/approved', [ProfileController::class, 'approved'])->name('profile.approved');
        Route::post('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
        // authorise create
        Route::post('/profile/create/approve/{id}', [ProfileController::class, 'approveCreate'])->name('profile.approveCreate');
        Route::post('/profile/create/reject/{id}', [ProfileController::class, 'rejectCreate'])->name('profile.rejectCreate');
        // authorise delete for profile
        // Route::post('/profile/delete/approve/{id}', [ProfileController::class, 'approveDelete'])->name('profile.approveDelete');
        // Route::post('/profile/delete/reject/{id}', [ProfileController::class, 'rejectDelete'])->name('profile.rejectDelete');


        // Institution
        Route::get('/institution-management', [InstitutionController::class, 'index'])->name('institution.index');
        Route::get('/institution-management/pending', [InstitutionController::class, 'pending'])->name('institution.pending');
        Route::get('/institution-management/rejected', [InstitutionController::class, 'rejected'])->name('institution.rejected');
        Route::get('/institution-management/approved', [InstitutionController::class, 'approved'])->name('institution.approved');
        Route::post('/institution/create', [InstitutionController::class, 'create'])->name('institution.create');
        Route::post('/institution/update/{id}', [InstitutionController::class, 'update'])->name('institution.update');
        Route::post('/institution/delete/{id}', [InstitutionController::class, 'delete'])->name('institution.delete');
        // authorise create
        Route::post('/institution/create/approve/{id}', [InstitutionController::class, 'approveCreate'])->name('institution.approveCreate');
        Route::post('/institution/create/reject/{id}', [InstitutionController::class, 'rejectCreate'])->name('institution.rejectCreate');
        // authorise update
        Route::post('/institution/update/approve/{id}', [InstitutionController::class, 'approveUpdate'])->name('institution.approveUpdate');
        Route::post('/institution/update/reject/{id}', [InstitutionController::class, 'rejectUpdate'])->name('institution.rejectUpdate');
        // authorise delete
        Route::post('/institution/delete/approve/{id}', [InstitutionController::class, 'approveDelete'])->name('institution.approveDelete');
        Route::post('/institution/delete/reject/{id}', [InstitutionController::class, 'rejectDelete'])->name('institution.rejectDelete');
    });

    Route::middleware(['isAuctioneer', 'isBidder'])->group(function () {

        // Route::get('/auction-management', [IQXController::class, 'index'])->name('auction.dashboard');

    });
});
