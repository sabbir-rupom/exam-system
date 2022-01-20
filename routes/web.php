<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;

use App\Http\Controllers\Entity\QuestionController as EntityQuestion;
use App\Http\Controllers\Entity\QuestionPaperController as EntityQuestionPaper;
use App\Http\Controllers\Entity\GroupController as EntityGroup;
use App\Http\Controllers\Entity\QuizController as EntityQuiz;

use App\Http\Controllers\Ajax\ComponentController as AjaxComponent;
use App\Http\Controllers\Ajax\EntityController as AjaxEntity;

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

        // Quiz management routes
        Route::resource('quizzes', EntityQuiz::class);

        // Question paper management routes
        Route::get('question-papers',  [EntityQuestionPaper::class, 'index'])->name('question-papers.index');
        Route::get('question-papers/{questionPaper}',  [EntityQuestionPaper::class, 'show'])->name('question-papers.show');
        Route::put('question-papers/{questionPaper}',  [EntityQuestionPaper::class, 'edit'])->name('question-papers.update');
        Route::get('question-papers/{questionPaper}/edit',  [EntityQuestionPaper::class, 'edit'])->name('question-papers.edit');
        // Route::resource('question-papers/{questionPaper}/edit', EntityQuestionPaper::class);
    });

    /**
     * Ajax route management
     */
    Route::any('/ajax/component/get', [AjaxComponent::class, 'index'])->name('ajax.component.get');
    Route::post('/ajax/entity/create', [AjaxEntity::class, 'create'])->name('ajax.entity.create');
    Route::delete('/ajax/entity/delete', [AjaxEntity::class, 'destroy'])->name('ajax.entity.delete');
    // Route::post('/ajax/quiz/exam/update', [AjaxQuiz::class, 'updateQuizExam']);

});
