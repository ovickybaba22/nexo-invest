<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\InvestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PlanController;

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

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/plans', [PlanController::class, 'index'])
    ->name('plans.index');

Route::get('/plans/{plan:slug}', [PlanController::class, 'show'])
    ->name('plans.show');

// NOWPayments IPN callback (no auth middleware so provider can call it)
Route::post('/nowpayments/ipn', [DepositController::class, 'ipn'])
    ->name('nowpayments.ipn');

// Routes that require the user to be logged in
Route::middleware(['auth'])->group(function () {

    // Main dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Deposits (NowPayments flow starts from here)
    Route::get('/deposits/create', [DepositController::class, 'create'])
        ->name('deposits.create');

    Route::post('/deposits', [DepositController::class, 'store'])
        ->name('deposits.store');

    // Withdrawals
    Route::get('/withdrawals', [WithdrawalController::class, 'index'])
        ->name('withdrawals.index');

    Route::post('/withdrawals', [WithdrawalController::class, 'store'])
        ->name('withdrawals.store');

    // Investments / plans
    Route::get('/invest/{plan:slug}', [InvestController::class, 'create'])
        ->name('invest.start');

    Route::post('/invest/{plan:slug}', [InvestController::class, 'store'])
        ->name('invest.store');

    // Profile (Breeze / Jetstream style)
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Auth scaffolding routes (login, register, etc.)
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}
