<?php

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
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\TablesController as AdminTablesController;
use Illuminate\Support\Facades\Artisan;

Route::prefix('auth')->group(function () {
    Route::view('/login', 'auth.login')->middleware('guest')->name('login');
    Route::post('/login', [AuthController::class,'login']);
    Route::get('/logout', [AuthController::class,'logout'])->middleware('auth')->name('logout');
});

Route::prefix('admin')->middleware(['auth','is_admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/set-cookie', [AdminDashboardController::class,'setCookie'])->name('admin.set.cookie');
    Route::resource('users', AdminUserController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('products', AdminProductController::class);
    Route::resource('tables', AdminTablesController::class)->only([
        'index','store','destroy'
    ]);
    Route::post('tables/bill', [AdminTablesController::class, 'bill']);

    Route::view('/profile', 'admin.profile')->name('admin.profile');
    Route::post('/profile', [AdminProfileController::class,'update'])->name('admin.profile.update');
});

Route::get('/test-command', function (){
    Artisan::call('migrate:fresh --seed');
});

Route::prefix('')->middleware(['auth','is_not_admin'])->group(function () {
    Route::get('', [HomeController::class,'index']);
    Route::post('check-pin', [HomeController::class,'checkPin'])->name('check.pin');
    Route::post('remove-pin', [HomeController::class,'removePin'])->name('remove.pin');
    Route::get('products', [HomeController::class,'products'])->name('products');
    Route::get('open-table', [HomeController::class,'cancelTableClosing'])->name('open-table');
    Route::post('order', [HomeController::class,'order'])->name('order');
    Route::get('orders', [HomeController::class,'getOrdersByTableId']);
});




