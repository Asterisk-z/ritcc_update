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

Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::get('/not-authorized', 'notAuthorised')->name('notAuthorised');
    Route::post('/sign-in', 'signIn')->name('signIn');
    Route::get('/sign-out', 'signOut')->name('signOut');
});

Route::controller(ProfileController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('inputterDashboard');
    Route::get('/profile-management', 'profilesIndex')->name('profilesIndex');
});

Route::controller(InstitutionController::class)->group(function () {
    Route::get('/institution-management', 'institutionsIndex')->name('institutionsIndex');
    Route::post('/create-institution', 'createInstitution')->name('createInstitution');
    Route::post('/update-institution/{id}', 'updateInstitution')->name('updateInstitution');
});

Route::controller(CertificateController::class)->group(function () {
    Route::get('/certificate-management', 'index')->name('certificatesIndex');
    Route::post('/create-certificate', 'create')->name('createCertificate');
    Route::post('/update-certificate/{id}', 'updateCertificate')->name('updateCertificate');
});
