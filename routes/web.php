<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Projects: create/edit/store/update/delete are managers only (registered first to avoid wildcard conflicts)
    Route::resource('projects', ProjectController::class)->only(['create', 'store', 'edit', 'update', 'destroy'])->middleware('can:manage-tasks');
    Route::resource('projects', ProjectController::class)->only(['index', 'show']);

    // Tasks: create, store, destroy are managers only (registered first to avoid wildcard conflicts)
    Route::resource('tasks', TaskController::class)->only(['create', 'store', 'destroy'])->middleware('can:manage-tasks');
    Route::resource('tasks', TaskController::class)->only(['index', 'show', 'edit', 'update']);

    // Users: full CRUD except show is managers only (registered first to avoid wildcard conflicts)
    Route::resource('users', UserController::class)->except(['show'])->middleware('can:manage-tasks');
    Route::resource('users', UserController::class)->only(['show']);
});

Route::get('/__test', function () {
    return 'OK';
});
