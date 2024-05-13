<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*=== Transaction Route Start ===*/
    Route::prefix('transactions')->name('transaction.')->group(function () {
        Route::get('/all', [TransactionController::class, 'index'])->name('index');
        Route::get('/deposit', [TransactionController::class, 'allDeposit'])->name('deposit');
        Route::get('/new-deposit', [TransactionController::class, 'createDeposit'])->name('newDeposit');
        Route::post('/new-deposit', [TransactionController::class, 'storeDeposit'])->name('storeDeposit');
        Route::get('/withdraw', [TransactionController::class, 'allWithdraw'])->name('withdraw');
        Route::get('/new-withdraw', [TransactionController::class, 'createWithdraw'])->name('newWithdraw');
        Route::post('/new-withdraw', [TransactionController::class, 'storeWithdraw'])->name('storeWithdraw');
    });
    /*=== Transaction Route End ===*/
});

require __DIR__.'/auth.php';
