<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Projects: index and show are public/collaborators; create/edit/store/update/delete are managers only
    Route::resource('projects', \App\Http\Controllers\ProjectController::class)->only(['index', 'show']);
    Route::resource('projects', \App\Http\Controllers\ProjectController::class)->except(['index', 'show'])->middleware('can:manage-tasks');

    // Tasks: index, show, edit, update are open (collaborators can edit only status); create, store, destroy are managers only
    Route::resource('tasks', \App\Http\Controllers\TaskController::class)->only(['index', 'show', 'edit', 'update']);
    Route::resource('tasks', \App\Http\Controllers\TaskController::class)->only(['create', 'store', 'destroy'])->middleware('can:manage-tasks');

    // Users: show is open (to click names and view profiles); index, create, edit, store, update, destroy are managers only
    Route::resource('users', \App\Http\Controllers\UserController::class)->only(['show']);
    Route::resource('users', \App\Http\Controllers\UserController::class)->except(['show'])->middleware('can:manage-tasks');
});
