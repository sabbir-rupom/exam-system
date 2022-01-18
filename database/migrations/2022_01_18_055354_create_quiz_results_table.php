<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('quiz_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->tinyInteger('type')->unsigned()->default(0)->comment('0: Unknown, 1: Regular Student');
            $table->string('quiz_name')->nullable();
            $table->smallInteger('pass_mark')->default(0);
            $table->smallInteger('questions')->default(0);
            $table->smallInteger('answers')->default(0);
            $table->tinyInteger('result')->default(0)->comment('0=pending, 1=passed, 2=failed');
            $table->timestamp('taken_at')->nullable();
            $table->smallInteger('duration')->default(0)->unsigned();
            $table->text('feedback')->nullable();
            $table->json('question_refs')->nullable();

            $table->unique(['quiz_id', 'user_id', 'type']);
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
        Schema::dropIfExists('quiz_results');
    }
}
