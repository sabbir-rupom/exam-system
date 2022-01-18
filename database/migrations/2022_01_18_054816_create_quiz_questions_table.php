<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->bigInteger('question_id')->unsigned();
            $table->bigInteger('quiz_id')->unsigned();

            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreign('quiz_id')->references('id')->on('quizzes');
            $table->timestamps();

            $table->unique(['question_id', 'quiz_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_questions');
    }
}
