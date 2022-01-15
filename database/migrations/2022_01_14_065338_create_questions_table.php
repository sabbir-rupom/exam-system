<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('owner_id')->constrained();
            $table->string('name');
            $table->mediumText('detail')->nullable();
            $table->tinyInteger('difficulty')->default(1)->comment('1=Easy, 2=Medium, 3=Hard, 4=Extreme');
            $table->mediumText('explanation')->nullable();
            $table->boolean('status')->default(0);
            $table->tinyInteger('question_type')->comment('details in question types table');

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
        Schema::dropIfExists('questions');
    }
}
