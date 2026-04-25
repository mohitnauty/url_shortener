<?php

use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShortUrlsController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'superadmin'])->group(function () {

    Route::get('/companies/create', [CompaniesController::class, 'create'])
        ->name('companies.create');

    Route::post('/companies/create', [CompaniesController::class, 'store'])
        ->name('companies.store');
    Route::match(['get', 'post'], '/companies/invite', [CompaniesController::class, 'invite'])
    ->name('companies.invite');
});

Route::middleware(['auth', 'shorturls'])->group(function () {

    Route::match(['get', 'post'], '/companies/admin', [CompaniesController::class, 'admin'])
        ->name('companies.admin');

    Route::match(['get', 'post'], '/short-urls/generate', [ShortUrlsController::class, 'generate'])
        ->name('urls.generate');
});

Route::get('/short-urls/download', [ShortUrlsController::class, 'downloadCsv'])
->middleware(['auth'])->name('urls.download');

Route::get('/u/{code}', [ShortUrlsController::class, 'redirect'])
    ->name('short.redirect');





require __DIR__.'/auth.php';
