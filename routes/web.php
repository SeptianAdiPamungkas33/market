<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use GuzzleHttp\Middleware;
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

// Redirect default ke login jika user mengakses root domain
Route::get('/', function () {
    return redirect()->route('login');
});

// Route untuk halaman login
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/proses-login', [LoginController::class, 'prosesLogin'])->name('proses.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/proses-register', [LoginController::class, 'prosesRegister'])->name('proses.register');

// Route::middleware(['auth'])->group(function () {
//     Route::get('/admin/dashboard', function () {
//         return view('pages.admin.dashboard');
//     })->name('dashboard-admin')->middleware('role:admin'); // Hanya Admin

//     Route::get('/user/dashboard', function () {
//         return view('pages.user.dashboard');
//     })->name('dashboard-user')->middleware('role:user'); // Hanya User
// });

// Middleware Admin
Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard Admin
    Route::get('/admin/dashboard', function () {
        return view('pages.admin.dashboard');
    })->name('dashboard-admin');

    // Product
    Route::get('/admin/product', [AdminController::class, 'product'])->name('product-admin');

    // Add Product
    Route::post('/admin/product/add/product', [AdminController::class, 'addProduct'])->name('add-product-admin');
    

    // Route::get('/profile', function () {
    //     return view('profile');
    // });
});


// User
Route::get('/user/dashboard', function () {
            return view('pages.user.dashboard');
        })->name('dashboard-user');