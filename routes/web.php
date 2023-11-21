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
Route::get('/iqx-dashboard', [IQXController::class, 'index'])->name('iqx.dashboard');
// profile
Route::get('/profile-management', [ProfileController::class, 'index'])->name('profile.index');
// Institution
Route::get('/institution-management', [InstitutionController::class, 'index'])->name('institution.index');
Route::get('/institution-management/pending', [InstitutionController::class, 'pending'])->name('institution.pending');
Route::get('/institution-management/rejected', [InstitutionController::class, 'rejected'])->name('institution.rejected');
Route::get('/institution-management/approved', [InstitutionController::class, 'approved'])->name('institution.approved');
Route::post('/institution/create', [InstitutionController::class, 'create'])->name('institution.create');
Route::post('/institution/update/{id}', [InstitutionController::class, 'update'])->name('institution.update');
Route::post('/institution/delete/{id}', [InstitutionController::class, 'delete'])->name('institution.delete');

// // iQX
// Route::group(['middleware' => ['auth', 'user.type:1']], function () {
//     // dashboard
//     Route::get('/iqx-dashboard', [IQXController::class, 'index'])->name('iqx.dashboard');
// });

// // Inputter
// Route::group(
//     ['middleware' => ['auth', 'user.type:1', 'user.type:2', 'user.type:4']],
//     function () {
//         // profile
//         Route::get('/profile-management', [ProfileController::class, 'index'])->name('profile.index');
//         // Institution
//         Route::get('/institution-management', [InstitutionController::class, 'index'])->name('institution.index');
//         Route::post('/institution/create', [InstitutionController::class, 'create'])->name('institution.create');
//         Route::post('/institution/update/{id}', [InstitutionController::class, 'update'])->name('institution.update');
//         Route::post('/institution/delete/{id}', [InstitutionController::class, 'delete'])->name('institution.delete');
//     }
// );