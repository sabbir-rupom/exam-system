<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Ajax\ComponentController as AjaxComponent;
use App\Http\Controllers\Ajax\EntityController as AjaxEntity;
use App\Http\Controllers\Entity\QuestionController as EntityQuestion;
use App\Http\Controllers\Entity\QuestionPaperController as EntityQuestionPaper;
use App\Http\Controllers\Entity\GroupController as EntityGroup;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboard;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
 */

Route::permanentRedirect('/index', '/');
Route::permanentRedirect('/home', '/');

Route::get('/', [HomeController::class, 'index']);

Route::group(['middleware' => 'guest'], function () {

});

Route::middleware(['auth'])->group(function () {

    Route::group(['middleware' => 'role.user:admin', 'prefix' => 'admin'], function () {
        /**
         * Include admin related route definitions
         */
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');

    });


    Route::group(['middleware' => 'role.user:owner'], function () {
        /**
         * Include admin related route definitions
         */
        Route::get('/dashboard', [OwnerDashboard::class, 'index'])->name('owner.dashboard');

        // Question management routes
        Route::resource('questions', EntityQuestion::class);

        // Group management routes
        Route::resource('groups', EntityGroup::class);

        // Question paper management routes
        Route::resource('question-papers', EntityQuestionPaper::class);
    });

    /**
     * Ajax route management
     */
    Route::any('/ajax/component/get', [AjaxComponent::class, 'index'])->name('ajax.component.get');
    Route::delete('/ajax/entity/delete', [AjaxEntity::class, 'destroy'])->name('ajax.entity.delete');
    // Route::post('/ajax/quiz/exam/update', [AjaxQuiz::class, 'updateQuizExam']);

});
