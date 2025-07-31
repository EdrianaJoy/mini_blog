<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminPostController;

Route::get('/', fn() => view('welcome'));

// All of these routes get the "web" middleware group automatically via RouteServiceProvider
Route::middleware(['auth','role:admin'])
     ->prefix('admin')
     ->name('admin.')
     ->group(function(){
         Route::get('dashboard', fn() => view('admin.dashboard'))
              ->name('dashboard');

    // 2) Admin‐only panel; uses the **alias** "role:admin"
    Route::prefix('admin')
         ->as('admin.')
         ->middleware(['role:admin'])    // <— here!
         ->group(function () {
             // GET /admin/dashboard
             Route::get('dashboard', [AdminDashboardController::class, 'index'])
     ->name('dashboard');

             // Approve / Reject buttons
             Route::post('posts/{post}/approve', [AdminPostController::class,'approve'])
                  ->name('posts.approve');
             Route::post('posts/{post}/reject',  [AdminPostController::class,'reject'])
                  ->name('posts.reject');
         });

    // 3) Public CRUD routes
    Route::resource('posts', PostController::class);

    // 4) Profile
    Route::get('/profile',   [ProfileController::class,'edit'])   ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class,'destroy'])->name('profile.destroy');

    // 5) Roles management (if you need it)
    Route::resource('roles', RoleController::class);
    Route::post('assign-role',[RoleController::class,'assignRole'])
         ->name('assign.role');
});

// Laravel Breeze / Jetstream auth routes
require __DIR__.'/auth.php';
