<?php

use App\Http\Controllers\Auth\LoginController;
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
Route::get('/', 'Auth\LoginController@login')->name('login');
Route::post('/sign-in', 'Auth\LoginController@login')->name('signIn');
Route::post('/sign-out', 'Auth\LoginController@signOut')->name('signOut');

// Inputter
Route::controller(ProfileController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('inputterDashboard');
    Route::get('/profile-management', 'profilesIndex')->name('profilesIndex');
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
// institution
Route::get('/dashboard', 'Authoriser\InstitutionController@index')->name('authoriser.institution');


// Auctioneer
// Bidder
// Super Admin
