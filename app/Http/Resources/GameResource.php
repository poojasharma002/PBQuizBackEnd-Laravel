<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Game;
use App\Models\settings;
use App\Http\Resources\QuestionResource;
class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
       return [
            'id' => $this->id,
            'name'=>$this->gamename,
            'gametype'=> $this->gametype,
            'schedule_time'=>$this->schedule_time,
            'schedule_date'=>$this->schedule_date,
            'level'=>$this->level,
            'tag'=>$this->tag,
            'host'=>$this->host,
            'music_file'=>$this->music_file,
            'host_video_snippet'=>$this->host_video_snippet,
            'game_image'=>$this->game_image,
            'high_perf_message'=>$this->high_perf_message,
            'low_perf_message'=>$this->low_perf_message,
            'round1_starting_video_snippet'=>$this->round1_starting_video_snippet,
            'round2_starting_video_snippet'=>$this->round2_starting_video_snippet,
            'round3_starting_video_snippet'=>$this->round3_starting_video_snippet,
            'time_down_video_snippet'=> $this->time_down_video_snippet,
            'round_1_question'=> $this->getRoundQuestions($this->round_1_questions),
            'round_2_question'=> $this->getRoundQuestions($this->round_2_questions),
            'round_3_question'=> $this->getRoundQuestions($this->round_3_questions)


        ];

    }
}
