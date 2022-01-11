<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboard;
use App\Http\Controllers\Owner\UserController as OwnerUser;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
 */

Route::get('/', [HomeController::class, 'index']);
Route::permanentRedirect('/index', '/');
Route::permanentRedirect('/home', '/');

Route::middleware(['auth', 'admin'])->group(function () {
    /**
     * Include admin related route definitions
     */
});

Route::middleware(['auth', 'owner'])->group(function () {
    Route::get('/', [OwnerDashboard::class, 'index'])->name('owner.dashboard');

    // User Routes
    Route::permanentRedirect('/user', '/user/list');
    Route::get('/user/list', [OwnerUser::class, 'index'])->name('owner.users');
    Route::get('/user/add', [OwnerUser::class, 'create'])->name('owner.user.add');
    Route::post('/user/add', [OwnerUser::class, 'store']);
    Route::get('/user/{user}', [OwnerUser::class, 'edit'])->name('owner.user.edit');
    Route::put('/user/{user}', [OwnerUser::class, 'update']);
    Route::delete('/user/{user}', [OwnerUser::class, 'delete'])->name('owner.user.delete');

    // Course Routes
    // Route::permanentRedirect('/course', '/course/list');
    // Route::get('/course/list', [CourseController::class, 'index'])->name('owner.course');
    // Route::get('/admin/course/add', [CourseController::class, 'create'])->name('owner.course.add');

});
Route::middleware(['auth', 'teacher'])->group(function () {
    // Route::get('/', [HomeController::class, 'userhome']);

});
Route::middleware(['auth', 'student'])->group(function () {
    // Route::get('/', [HomeController::class, 'userhome']);

});
