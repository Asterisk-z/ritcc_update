<?php

use App\Http\Controllers\Authoriser\InstitutionController as AuthoriserInstitutionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Authoriser\ProfileController as AuthoriserProfileController;
use App\Http\Controllers\FMDQ\IQXController;
use App\Http\Controllers\inputter\CertificateController;
use App\Http\Controllers\Inputter\InstitutionController;
use App\Http\Controllers\Inputter\ProfileController;
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

// iQX
Route::get('/iqx-dashboard', [IQXController::class, 'index'])->name('iqx.dashboard');

// Inputter
Route::controller(ProfileController::class)->group(function () {
    // Route::get('/dashboard', 'dashboard')->name('inputterDashboard');
    Route::get('/profile-management', 'profilesIndex')->name('inputter.profile');
});

Route::controller(InstitutionController::class)->group(function () {
    Route::get('/institution-management', 'institutionsIndex')->name('institutionsIndex');
    Route::post('/create-institution', 'createInstitution')->name('createInstitution');
    Route::post('/update-institution/{id}', 'updateInstitution')->name('updateInstitution');
    Route::post('/delete-institution/{id}', 'deleteInstitution')->name('deleteInstitution');
});

Route::controller(CertificateController::class)->group(function () {
    Route::get('/certificate-management', 'index')->name('certificatesIndex');
    Route::post('/create-certificate', 'create')->name('createCertificate');
    Route::post('/update-certificate/{id}', 'updateCertificate')->name('updateCertificate');
});

// Authoriser
// profile
Route::get('/authoriser-profile', [AuthoriserProfileController::class], 'index')->name('authoriser.profile');
// institution
Route::get('/authoriser-institution', [AuthoriserInstitutionController::class, 'index'])->name('authoriser.institution');

// Auctioneer
// Bidder
