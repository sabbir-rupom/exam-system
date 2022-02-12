<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreignId('subject_id');
            $table->smallInteger('type')->default(0)->comment('0: Unknown/Random, 1: MCQ/Quiz, 2: Written');
            $table->string('name', 300);
            $table->smallInteger('score')->default(10);
            $table->smallInteger('pass_mark')->default(0);
            $table->smallInteger('duration')->default(1)->comment('In minutes');
            $table->text('detail')->nullable();
            $table->boolean('legacy')->default(0)->comment('Legacy question paper flag');
            $table->json('format')->nullable();
            $table->boolean('status')->default(1);

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
        Schema::dropIfExists('exams');
    }
}
