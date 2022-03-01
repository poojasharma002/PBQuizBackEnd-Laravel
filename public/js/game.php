<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\question;
use App\Models\settings;

class game extends Model
{
    use HasFactory;
    //protected fillable 
    protected $fillable = ['gamename', 'gametype', 'schedule_date','schedule_time', 'level', 'tag', 'host_video_snippet','music_file', 'game_image', 'high_perf_message','low_perf_message', 'round_1_questions', 'round_1_host_video_snippet', 'round_2_questions', 'round_2_host_video_snippet', 'round_3_questions', 'round_3_host_video_snippet', 'trophy', 'published','round1_starting_video_snippet', 'round2_starting_video_snippet', 'round3_starting_video_snippet', 'deleted'];

    public function getRoundQuestions($questionIds){
        $round_questions = unserialize($questionIds);
        $round_question = question::whereIn('id',$round_questions)->get()->toArray();
        foreach ($round_question as $key => $value) {
           $round_question[$key]['host_name'] =  settings::where('id',$value['host'])->first()->name;
        }
        return $round_question;
      
    }
}
