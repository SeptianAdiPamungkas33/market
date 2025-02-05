<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Models\Role;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/login', [LoginController::class, 'login']);
// Route::post('/login', [LoginController::class, 'prosesLogin']);


// Route::get('/dashboard-admin', [AdminController::class, 'index'])->name(name: 'dashboard-admin');

// Route untuk halaman login
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/proses-login', [LoginController::class, 'prosesLogin'])->name('proses.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route dashboard berdasarkan role
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard-admin')->middleware('role:1'); // Hanya bisa diakses oleh role_id 1 (Admin)

    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard-user')->middleware('role:2'); // Hanya bisa diakses oleh role_id 2 (User)
});

// Redirect default ke login jika user mengakses root domain
Route::get('/', function () {
    return redirect()->route('login');
});
