<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FMDQ\AuctionManagementController;
use App\Http\Controllers\FMDQ\CertificateManagementController;
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
Route::get('/change-password', [LoginController::class, 'changePassword'])->name('changePassword');
// dashboard

Route::middleware(['auth'])->group(function () {
    Route::post('/update-password', [LoginController::class, 'updatePassword'])->name('updatePassword');
    //
    Route::middleware(['isSuperUser'])->group(function () {

        Route::get('/iqx-dashboard', [IQXController::class, 'index'])->name('iqx.dashboard');
        Route::get('/activity-logs', [IQXController::class, 'activityLog'])->name('iqx.logs');
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

        // Auctions
        Route::get('/auction-management', [AuctionManagementController::class, 'index'])->name('auction.mgt.dashboard');
        Route::get('/auction-management/pending', [AuctionManagementController::class, 'pendingIndex'])->name('auction.mgt.pending');
        Route::get('/auction-management/rejected', [AuctionManagementController::class, 'rejectedIndex'])->name('auction.mgt.rejected');
        Route::get('/auction-management/approved', [AuctionManagementController::class, 'approvedIndex'])->name('auction.mgt.approved');
        Route::post('/auction-management/create', [AuctionManagementController::class, 'create'])->name('auction.mgt.create');
        Route::post('/auction-management/approve/create', [AuctionManagementController::class, 'approveCreate'])->name('auction.mgt.approve.create');
        Route::post('/auction-management/reject/create', [AuctionManagementController::class, 'rejectCreate'])->name('auction.mgt.reject.create');
        Route::post('/auction-management/update', [AuctionManagementController::class, 'update'])->name('auction.mgt.update');
        Route::post('/auction-management/approve/update', [AuctionManagementController::class, 'approveUpdate'])->name('auction.mgt.approve.update');
        Route::post('/auction-management/reject/update', [AuctionManagementController::class, 'rejectUpdate'])->name('auction.mgt.reject.update');
        Route::post('/auction-management/delete', [AuctionManagementController::class, 'delete'])->name('auction.mgt.delete');
        Route::post('/auction-management/approve/delete', [AuctionManagementController::class, 'approveDelete'])->name('auction.mgt.approve.delete');
        Route::post('/auction-management/reject/delete', [AuctionManagementController::class, 'rejectDelete'])->name('auction.mgt.reject.delete');

        // Certificate
        Route::get('/certificate-management', [CertificateManagementController::class, 'index'])->name('certificate.mgt.dashboard');
        Route::get('/certificate-management/pending', [CertificateManagementController::class, 'pendingIndex'])->name('certificate.mgt.pending');
        Route::get('/certificate-management/rejected', [CertificateManagementController::class, 'rejectedIndex'])->name('certificate.mgt.rejected');
        Route::get('/certificate-management/approved', [CertificateManagementController::class, 'approvedIndex'])->name('certificate.mgt.approved');
        Route::post('/certificate-management/create', [CertificateManagementController::class, 'create'])->name('certificate.mgt.create');
        Route::post('/certificate-management/approve/create', [CertificateManagementController::class, 'approveCreate'])->name('certificate.mgt.approve.create');
        Route::post('/certificate-management/reject/create', [CertificateManagementController::class, 'rejectCreate'])->name('certificate.mgt.reject.create');
        Route::post('/certificate-management/update', [CertificateManagementController::class, 'update'])->name('certificate.mgt.update');
        Route::post('/certificate-management/approve/update', [CertificateManagementController::class, 'approveUpdate'])->name('certificate.mgt.approve.update');
        Route::post('/certificate-management/reject/update', [CertificateManagementController::class, 'rejectUpdate'])->name('certificate.mgt.reject.update');
        Route::post('/certificate-management/delete', [CertificateManagementController::class, 'delete'])->name('certificate.mgt.delete');
        Route::post('/certificate-management/approve/delete', [CertificateManagementController::class, 'approveDelete'])->name('certificate.mgt.approve.delete');
        Route::post('/certificate-management/reject/delete', [CertificateManagementController::class, 'rejectDelete'])->name('certificate.mgt.reject.delete');

    });

});
