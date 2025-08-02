<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminPostController;

// 1) Public homepage
Route::get('/', fn() => view('welcome'));

// 2) Shared “dashboard” for all logged-in users
Route::middleware(['auth', 'verified'])
    ->get('/dashboard', function () {
        // if you’re an admin, bounce into the admin area
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        // otherwise show your regular dashboard view
        return view('dashboard');
    })
    ->name('dashboard');

// 3) Admin-only routes
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        // GET /admin/dashboard → named “admin.dashboard”
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // extra admin post actions
        Route::post('posts/{post}/approve', [AdminPostController::class, 'approve'])
            ->name('posts.approve');
        Route::post('posts/{post}/reject', [AdminPostController::class, 'reject'])
            ->name('posts.reject');

        // regular CRUD under /admin/posts
        Route::resource('posts', PostController::class);

        // profile management
        Route::get('profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])
            ->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])
            ->name('profile.destroy');

        // roles & permissions
        Route::resource('roles', RoleController::class);
        Route::post('assign-role', [RoleController::class, 'assignRole'])
            ->name('assign.role');
    });

// 4) Breeze/Jetstream auth routes
require __DIR__ . '/auth.php';
