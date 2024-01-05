<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Bank\BankDashboardController;
use App\Http\Controllers\FMDQ\AuctionManagementController;
use App\Http\Controllers\FMDQ\CertificateManagementController;
use App\Http\Controllers\FMDQ\DashboardController;
use App\Http\Controllers\FMDQ\InstitutionController;
use App\Http\Controllers\FMDQ\ProfileController;
use App\Http\Controllers\FMDQ\SystemController;
use App\Http\Controllers\FMDQ\TradeManagementController;
use App\Http\Controllers\SecurityTypeController;
use App\Http\Controllers\SettlementController;
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
// reset password
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('form.forgetPassword');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('submit.forgotPassword');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('get.resetPassword');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('post.resetPassword');


Route::middleware(['auth'])->group(function () {
    Route::post('/update-password', [LoginController::class, 'updatePassword'])->name('updatePassword');
    // // all logs
    // Route::get('/all-activities', DashboardController::class, 'allLogs')->name('allLogs');
    // //
    Route::get('/my-activities', [DashboardController::class, 'userLogs'])->name('myLogs');
    //
    Route::middleware(['isSuperUser'])->group(function () {

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
        Route::get('/auction-management/auctions', [AuctionManagementController::class, 'auctionsIndex'])->name('auction.mgt.auctions');
        Route::get('/auction-management/history', [AuctionManagementController::class, 'auctionsHistory'])->name('auction.mgt.history');
        Route::get('/auction-management/pending', [AuctionManagementController::class, 'pendingIndex'])->name('auction.mgt.pending');
        Route::post('/auction-management/create', [AuctionManagementController::class, 'create'])->name('auction.mgt.create');
        Route::post('/auction-management/update', [AuctionManagementController::class, 'update'])->name('auction.mgt.update');
        Route::post('/auction-management/delete', [AuctionManagementController::class, 'delete'])->name('auction.mgt.delete');

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

        // // Bidding
        // Route::get('/trade-management', [TradeManagementController::class, 'index'])->name('trade.mgt.dashboard');
        // Route::get('/trade-management/bids', [TradeManagementController::class, 'bidIndex'])->name('trade.mgt.bids');
        // Route::post('/trade-management/create', [TradeManagementController::class, 'create'])->name('trade.mgt.create');
        // Route::post('/trade-management/update', [TradeManagementController::class, 'update'])->name('trade.mgt.update');
        // Route::post('/trade-management/delete', [TradeManagementController::class, 'delete'])->name('trade.mgt.delete');
    });

    // inputter
    Route::middleware(['isInputter'])->group(function () {
        // profile
        Route::get('/inputter/profile-management', [ProfileController::class, 'index'])->name('inputter.profile.index');
        Route::get('/inputter/profile-management/pending', [ProfileController::class, 'pending'])->name('inputter.profile.pending');
        Route::get('/inputter/profile-management/rejected', [ProfileController::class, 'rejected'])->name('inputter.profile.rejected');
        Route::get('/inputter/profile-management/approved', [ProfileController::class, 'approved'])->name('inputter.profile.approved');
        Route::post('/inputter/profile/create', [ProfileController::class, 'create'])->name('inputter.profile.create');
        Route::post('/inputter/profile/deactivate/{id}', [ProfileController::class, 'deactivateProfile'])->name('inputter.profile.deactivateProfile');
        // institution
        Route::get('/inputter/institution-management', [InstitutionController::class, 'index'])->name('inputter.institution.index');
        Route::get('/inputter/institution-management/pending', [InstitutionController::class, 'pending'])->name('inputter.institution.pending');
        Route::get('/inputter/institution-management/rejected', [InstitutionController::class, 'rejected'])->name('inputter.institution.rejected');
        Route::get('/inputter/institution-management/approved', [InstitutionController::class, 'approved'])->name('inputter.institution.approved');
        Route::post('/inputter/institution/create', [InstitutionController::class, 'create'])->name('inputter.institution.create');
        Route::post('/inputter/institution/update/{id}', [InstitutionController::class, 'update'])->name('inputter.institution.update');
        Route::post('/inputter/institution/delete/{id}', [InstitutionController::class, 'delete'])->name('inputter.institution.delete');
        // certificate
        Route::get('/inputter/certificate-management', [CertificateManagementController::class, 'index'])->name('inputter.certificate.mgt.dashboard');
        Route::get('/inputter/certificate-management/pending', [CertificateManagementController::class, 'pendingIndex'])->name('inputter.certificate.mgt.pending');
        Route::get('/inputter/certificate-management/rejected', [CertificateManagementController::class, 'rejectedIndex'])->name('inputter.certificate.mgt.rejected');
        Route::get('/inputter/certificate-management/approved', [CertificateManagementController::class, 'approvedIndex'])->name('inputter.certificate.mgt.approved');
        Route::post('/inputter/certificate-management/create', [CertificateManagementController::class, 'create'])->name('inputter.certificate.mgt.create');
        Route::post('/inputter/certificate-management/update', [CertificateManagementController::class, 'update'])->name('inputter.certificate.mgt.update');
        Route::post('/inputter/certificate-management/delete', [CertificateManagementController::class, 'delete'])->name('inputter.certificate.mgt.delete');
        // auctions
        Route::get('/inputter/auction-management', [AuctionManagementController::class, 'index'])->name('inputter.auction.mgt.dashboard');
        Route::get('/inputter/auction-management/auctions', [AuctionManagementController::class, 'auctionsIndex'])->name('inputter.auction.mgt.auctions');
        Route::get('/inputter/auction-management/history', [AuctionManagementController::class, 'auctionsHistory'])->name('inputter.auction.mgt.history');
        Route::post('/inputter/auction-management/delete', [AuctionManagementController::class, 'delete'])->name('inputter.auction.mgt.delete');
        Route::post('/inputter/auction-management/update', [AuctionManagementController::class, 'update'])->name('inputter.auction.mgt.update');
        Route::get('/inputter/auction-management/bids/{id}', [AuctionManagementController::class, 'auctionBids'])->name('inputter.auction.mgt.bids');
        Route::get('/inputter/auction-management/pending', [AuctionManagementController::class, 'pendingIndex'])->name('inputter.auction.mgt.pending');
        Route::get('/inputter/auction-management/rejected', [AuctionManagementController::class, 'rejectedIndex'])->name('inputter.auction.mgt.rejected');
        Route::get('/inputter/auction-management/approved', [AuctionManagementController::class, 'approvedIndex'])->name('inputter.auction.mgt.approved');
        Route::post('/inputter/auction-management/create', [AuctionManagementController::class, 'create'])->name('inputter.auction.mgt.create');
        // system settings
        Route::get('/system-settings', [SystemController::class, 'index'])->name('system.settings');
        Route::get('/packages', [SystemController::class, 'packagesIndex'])->name('packages');
        Route::post('/create-package', [SystemController::class, 'packageStore'])->name('createPackage');
        Route::post('/update-package/{id}', [SystemController::class, 'packageUpdate'])->name('updatePackage');
        Route::post('/delete-package', [SystemController::class, 'packageDelete'])->name('deletePackage');
        //
        Route::get('/public-holidays', [SystemController::class, 'holidaysIndex'])->name('publicHolidays');
        Route::post('/create-holiday', [SystemController::class, 'storeHoliday'])->name('storeHoliday');
        Route::post('/update-holiday', [SystemController::class, 'updateHoliday'])->name('updateHoliday');
        Route::post('/delete-holiday', [SystemController::class, 'deleteHoliday'])->name('deleteHoliday');
        //
        Route::get('/auction-windows', [SystemController::class, 'windowsIndex'])->name('auctionWindows');
        Route::post('/create-window', [SystemController::class, 'storeWindow'])->name('storeWindow');
        Route::post('/update-window', [SystemController::class, 'updateWindow'])->name('updateWindow');
        Route::post('/delete-window', [SystemController::class, 'deleteWindow'])->name('deleteWindow');
        //
        Route::get('/security-type', [SecurityTypeController::class, 'index'])->name('securityType');
        Route::post('/create-security-type', [SecurityTypeController::class, 'store'])->name('storeSecurityType');
        Route::post('/update-security-type', [SecurityTypeController::class, 'update'])->name('updateSecurityType');
        Route::post('/delete-security-type', [SecurityTypeController::class, 'destroy'])->name('deleteSecurityType');
    });

    // authoriser
    Route::middleware(['isAuthoriser'])->group(function () {
        // profile
        Route::get('/authoriser/profile-management', [ProfileController::class, 'index'])->name('authoriser.profile.index');
        Route::get('/authoriser/profile-management/pending', [ProfileController::class, 'pending'])->name('authoriser.profile.pending');
        Route::get('/authoriser/profile-management/rejected', [ProfileController::class, 'rejected'])->name('authoriser.profile.rejected');
        Route::get('/authoriser/profile-management/approved', [ProfileController::class, 'approved'])->name('authoriser.profile.approved');
        Route::post('/authoriser/profile/create/approve/{id}', [ProfileController::class, 'approveCreate'])->name('authoriser.profile.approveCreate');
        Route::post('/authoriser/profile/create/reject/{id}', [ProfileController::class, 'rejectCreate'])->name('authoriser.profile.rejectCreate');
        Route::post('/authoriser/profile/delete/approve/{id}', [ProfileController::class, 'approveDelete'])->name('authoriser.profile.approveDelete');
        Route::post('/authoriser/profile/delete/reject/{id}', [ProfileController::class, 'rejectDelete'])->name('authoriser.profile.rejectDelete');

        // Institution
        Route::get('/authoriser/institution-management', [InstitutionController::class, 'index'])->name('authoriser.institution.index');
        Route::get('/authoriser/institution-management/pending', [InstitutionController::class, 'pending'])->name('authoriser.institution.pending');
        Route::get('/authoriser/institution-management/rejected', [InstitutionController::class, 'rejected'])->name('authoriser.institution.rejected');
        Route::get('/authoriser/institution-management/approved', [InstitutionController::class, 'approved'])->name('authoriser.institution.approved');
        Route::post('/authoriser/institution/create', [InstitutionController::class, 'create'])->name('authoriser.institution.create');
        Route::post('/authoriser/institution/update/{id}', [InstitutionController::class, 'update'])->name('authoriser.institution.update');
        Route::post('/authoriser/institution/delete/{id}', [InstitutionController::class, 'delete'])->name('authoriser.institution.delete');
        Route::post('/authoriser/institution/create/approve/{id}', [InstitutionController::class, 'approveCreate'])->name('authoriser.institution.approveCreate');
        Route::post('/authoriser/institution/create/reject/{id}', [InstitutionController::class, 'rejectCreate'])->name('authoriser.institution.rejectCreate');
        Route::post('/authoriser/institution/update/approve/{id}', [InstitutionController::class, 'approveUpdate'])->name('authoriser.institution.approveUpdate');
        Route::post('/authoriser/institution/update/reject/{id}', [InstitutionController::class, 'rejectUpdate'])->name('authoriser.institution.rejectUpdate');
        Route::post('/authoriser/institution/delete/approve/{id}', [InstitutionController::class, 'approveDelete'])->name('authoriser.institution.approveDelete');
        Route::post('/authoriser/institution/delete/reject/{id}', [InstitutionController::class, 'rejectDelete'])->name('authoriser.institution.rejectDelete');

        // auctions
        Route::get('/authoriser/auction-management', [AuctionManagementController::class, 'index'])->name('authoriser.auction.mgt.dashboard');
        Route::get('/authoriser/auction-management/pending', [AuctionManagementController::class, 'pendingIndex'])->name('authoriser.auction.mgt.pending');
        Route::get('/authoriser/auction-management/rejected', [AuctionManagementController::class, 'rejectedIndex'])->name('authoriser.auction.mgt.rejected');
        Route::get('/authoriser/auction-management/approved', [AuctionManagementController::class, 'approvedIndex'])->name('authoriser.auction.mgt.approved');
        Route::post('/auction-management/approve/delete', [AuctionManagementController::class, 'approveDelete'])->name('auction.mgt.approve.delete');
        Route::post('/auction-management/reject/delete', [AuctionManagementController::class, 'rejectDelete'])->name('auction.mgt.reject.delete');
        Route::post('/auction-management/approve/create', [AuctionManagementController::class, 'approveCreate'])->name('auction.mgt.approve.create');
        Route::post('/auction-management/reject/create', [AuctionManagementController::class, 'rejectCreate'])->name('auction.mgt.reject.create');
        Route::get('/auction-management/rejected', [AuctionManagementController::class, 'rejectedIndex'])->name('auction.mgt.rejected');
        Route::get('/auction-management/approved', [AuctionManagementController::class, 'approvedIndex'])->name('auction.mgt.approved');
        Route::post('/auction-management/approve/update', [AuctionManagementController::class, 'approveUpdate'])->name('auction.mgt.approve.update');
        Route::post('/auction-management/reject/update', [AuctionManagementController::class, 'rejectUpdate'])->name('auction.mgt.reject.update');
    });

    Route::middleware(['isBank'])->group(function () {

        Route::get('/bank-dashboard', [BankDashboardController::class, 'index'])->name('bank.dashboard');
        Route::get('/auctions', [AuctionManagementController::class, 'auctionsIndex'])->name('bank.mgt.auctions');
        Route::get('/certificates', [CertificateManagementController::class, 'myIndex'])->name('bank.mgt.certificates');

        Route::get('/trade-management/{id?}', [TradeManagementController::class, 'index'])->name('trade.mgt.dashboard');
        Route::get('/trade-management/bids', [TradeManagementController::class, 'bidIndex'])->name('trade.mgt.bids');
        Route::post('/trade-management/create', [TradeManagementController::class, 'create'])->name('trade.mgt.create');
        Route::post('/trade-management/update', [TradeManagementController::class, 'update'])->name('trade.mgt.update');
        Route::post('/trade-management/delete', [TradeManagementController::class, 'delete'])->name('trade.mgt.delete');

        Route::get('auctions/allocation', [AuctionManagementController::class, 'allocation'])->name('auction.mgt.allocation');
        Route::post('auction/close', [AuctionManagementController::class, 'closeAuction'])->name('auction.mgt.close');
        Route::post('auction/award', [AuctionManagementController::class, 'awardAuction'])->name('auction.mgt.award');
        Route::post('auction/cancel', [AuctionManagementController::class, 'awardCancelAuction'])->name('auction.mgt.cancel.award');
        Route::get('/auctions/bids/{id}', [AuctionManagementController::class, 'auctionBids'])->name('auction.mgt.bids');
        Route::get('auctions/results/{id?}', [AuctionManagementController::class, 'results'])->name('auction.mgt.results');
    });

    // firs
    Route::middleware(['isFirs'])->group(function () {
        // Certificate
        Route::get('/firs/certificate-management', [CertificateManagementController::class, 'index'])->name('firs.certificate.mgt.dashboard');
        Route::get('/firs/certificate-management/pending', [CertificateManagementController::class, 'pendingIndex'])->name('firs.certificate.mgt.pending');
        Route::get('/firs/certificate-management/rejected', [CertificateManagementController::class, 'rejectedIndex'])->name('firs.certificate.mgt.rejected');
        Route::get('/firs/certificate-management/approved', [CertificateManagementController::class, 'approvedIndex'])->name('firs.certificate.mgt.approved');
        Route::post('/firs/certificate-management/create', [CertificateManagementController::class, 'create'])->name('firs.certificate.mgt.create');
        Route::post('/firs/certificate-management/update', [CertificateManagementController::class, 'update'])->name('firs.certificate.mgt.update');
        Route::post('/firs/certificate-management/delete', [CertificateManagementController::class, 'delete'])->name('firs.certificate.mgt.delete');
        Route::post('/firs/certificate-management/approve/create', [CertificateManagementController::class, 'approveCreate'])->name('firs.certificate.mgt.approve.create');
        Route::post('/firs/certificate-management/reject/create', [CertificateManagementController::class, 'rejectCreate'])->name('firs.certificate.mgt.reject.create');
        Route::post('/firs/certificate-management/approve/update', [CertificateManagementController::class, 'approveUpdate'])->name('firs.certificate.mgt.approve.update');
        Route::post('/firs/certificate-management/reject/update', [CertificateManagementController::class, 'rejectUpdate'])->name('firs.certificate.mgt.reject.update');
        Route::post('/firs/certificate-management/approve/delete', [CertificateManagementController::class, 'approveDelete'])->name('firs.certificate.mgt.approve.delete');
        Route::post('/firs/certificate-management/reject/delete', [CertificateManagementController::class, 'rejectDelete'])->name('firs.certificate.mgt.reject.delete');
    });
    // auctioneer

    // bidder

    Route::get('settlement', [SettlementController::class, 'index'])->name('settlement');
    Route::get('settlement/bids/{id}', [SettlementController::class, 'bidder'])->name('settlement.bidder');
    Route::get('settlement/bids/{id}/settle', [SettlementController::class, 'settle'])->name('settlement.bid.settle');
});
