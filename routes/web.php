<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\LicenseCategoryController;
use App\Http\Controllers\LicenseRequestController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Trasy autoryzacyjne wygenerowane przez Breeze
require __DIR__.'/auth.php';

// Trasy dostępne dla wszystkich zalogowanych użytkowników
Route::middleware('auth')->group(function () {
    // Edycja profilu (ProfileController z Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Podstawowe licencje - dostęp dla wszystkich zalogowanych
    Route::get('/licenses', [LicenseController::class, 'index'])->name('licenses.index');
    Route::get('/my-licenses', [LicenseController::class, 'myLicenses'])->name('licenses.my');

    // Wnioski o licencje (dodawanie, edycja własnych, usuwanie) dla użytkowników
    Route::resource('license-requests', LicenseRequestController::class);
});

// Trasy dla moderatora i admina
Route::middleware(['auth', 'role:moderator,admin'])->group(function () {
    // Lista wszystkich licencji
    Route::get('/all-licenses', [LicenseController::class, 'all'])->name('licenses.all');

    // Zarządzanie licencjami (CRUD, poza index, który jest już dla userów)
    Route::resource('licenses', LicenseController::class)->except(['index']);

    // Kategorie licencji (pełen CRUD)
    Route::resource('license-categories', LicenseCategoryController::class);

    // Akceptacja / odrzucanie wniosków
    Route::patch('/license-requests/{licenseRequest}/approve', [LicenseRequestController::class, 'approve'])->name('license_requests.approve');
    Route::patch('/license-requests/{licenseRequest}/reject', [LicenseRequestController::class, 'reject'])->name('license_requests.reject');
});

// Trasy wyłącznie dla admina
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserManagementController::class);
});
