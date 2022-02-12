<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\DashboardController;

use App\Http\Controllers\Ajax\ComponentController as AjaxComponent;
use App\Http\Controllers\Ajax\EntityController as AjaxEntity;
use App\Module\CourseCatalogue\Controllers\CategoryClassController;
use App\Module\CourseCatalogue\Controllers\CategoryController;
use App\Module\CourseCatalogue\Controllers\SubjectController;
use App\Module\TestPaper\Controllers\ExamController;
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

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route::group(['middleware' => 'role.user:admin', 'prefix' => 'admin'], function () {
    Route::group(['middleware' => 'role.user:admin'], function () {
        /**
         * Include admin related route definitions
         */
        Route::group(['prefix' => 'entity', 'as'=>'entity.'], function(){
            Route::resource('category', CategoryController::class);
            Route::resource('category-class', CategoryClassController::class);
            Route::resource('subject', SubjectController::class);
        });
    });

    Route::group(['middleware' => 'role.user:examiner'], function () {
        /**
         * Include admin related route definitions
         */
        Route::group(['prefix' => 'entity', 'as'=>'entity.'], function(){
            Route::resource('exam', ExamController::class);
        });
    });


    // Route::group(['middleware' => 'role.user:owner'], function () {
    //     /**
    //      * Include admin related route definitions
    //      */
    //     Route::get('/dashboard', [OwnerDashboard::class, 'index'])->name('owner.dashboard');

    //     // Question management routes
    //     Route::resource('questions', EntityQuestion::class);

    //     // Group management routes
    //     Route::resource('groups', EntityGroup::class);

    //     // Quiz management routes
    //     Route::resource('quizzes', EntityQuiz::class);

    //     // Question paper management routes
    //     Route::get('question-papers',  [EntityQuestionPaper::class, 'index'])->name('question-papers.index');
    //     Route::get('question-papers/{questionPaper}',  [EntityQuestionPaper::class, 'show'])->name('question-papers.show');
    //     Route::put('question-papers/{questionPaper}',  [EntityQuestionPaper::class, 'edit'])->name('question-papers.update');
    //     Route::get('question-papers/{questionPaper}/edit',  [EntityQuestionPaper::class, 'edit'])->name('question-papers.edit');
    //     // Route::resource('question-papers/{questionPaper}/edit', EntityQuestionPaper::class);
    // });

    /**
     * Ajax route management
     */
    Route::any('/ajax/component/get', [AjaxComponent::class, 'index'])->name('ajax.component.get');
    Route::post('/ajax/entity/create', [AjaxEntity::class, 'create'])->name('ajax.entity.create');
    Route::delete('/ajax/entity/delete', [AjaxEntity::class, 'destroy'])->name('ajax.entity.delete');
    // Route::post('/ajax/quiz/exam/update', [AjaxQuiz::class, 'updateQuizExam']);

});
