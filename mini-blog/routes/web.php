<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// Authenticated & verified user routes
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    // ← this MUST be inside that middleware group ↓
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })
    ->middleware('role:admin')
    ->name('admin.dashboard');

    // Posts (includes index, create, store, show, edit, update, destroy)
    Route::resource('posts', PostController::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Roles
    Route::resource('roles', RoleController::class);
    Route::post('/assign-role', [RoleController::class, 'assignRole'])->name('assign.role');
});

// Load authentication routes (login/register/etc.)
require __DIR__ . '/auth.php';
