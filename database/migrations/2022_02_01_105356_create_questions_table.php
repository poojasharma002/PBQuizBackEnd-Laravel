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
            $table->id();
            $table->longText('video_code');
            $table->string('question');
            $table->string('option_one');
            $table->string('option_two');
            $table->string('option_three');
            $table->string('correct_answer');
            $table->string('difficulty_level');
            $table->string('tags');
            $table->longText('music_code');
            $table->string('host');
            $table->integer('question_time');
            $table->string('question_success_message');
            $table->string('question_fail_message');
            $table->string('deleted')->default('0');
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
