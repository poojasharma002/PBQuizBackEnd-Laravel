<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();     
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('game_id')->unsigned();     
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->integer('correct_answer');
            $table->integer('incorrect_answer');
            $table->integer('skipped_question');
            $table->integer('total_questions');
            $table->integer('total_score');
            // $table->integer('game_won');
            $table->integer('trophy_won');
            $table->integer('star_won');
            $table->string('game_date');
            $table->string('game_time');
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
        Schema::dropIfExists('statistics');
    }
}
