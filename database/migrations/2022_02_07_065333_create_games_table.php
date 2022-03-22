<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('gamename');
            $table->string('gametype');
            $table->date('schedule_date')->nullable();
            $table->time('schedule_time')->nullable();
            $table->timestamp('game_start_time')->nullable();
            $table->string('level');
            $table->string('tag');
            $table->string('host');
            $table->string('music_file');
            $table->longText('host_video_snippet');
            $table->string('game_image');
            $table->string('high_perf_message');
            $table->string('low_perf_message');
            $table->longText('round1_starting_video_snippet');
            $table->string('round_1_questions');
            // $table->longText('round_1_host_video_snippet');
            $table->longText('round2_starting_video_snippet');
            $table->string('round_2_questions');
            // $table->longText('round_2_host_video_snippet');
            $table->longText('round3_starting_video_snippet');
            $table->string('round_3_questions');
            // $table->longText('round_3_host_video_snippet');
            $table->string('trophy');
            $table->string('published');
            $table->string('time_down_video_snippet');
            $table->integer('deleted')->default(0);
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
        Schema::dropIfExists('games');
    }
}
