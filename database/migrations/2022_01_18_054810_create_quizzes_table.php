<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->tinyInteger('question_amount')->default(1);
            $table->smallInteger('duration')->default(1)->comment('value shall be in minutes');
            $table->smallInteger('pass_mark')->default(0)->comment('0 to 100%');
            $table->boolean('status')->default(0);
            $table->json('difficulty_order')->nullable();
            $table->tinyInteger('type')->default(1)->comment('1: Random, 2: Question Paper');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
}
