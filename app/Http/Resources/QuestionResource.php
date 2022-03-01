<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $incorrect_answer = [
            "option_one"=> $this->option_one,
            "option_two"=> $this->option_two,
        ];
        return [
            "id"=> $this->id,
            "video_code"=> $this->video_code,
            "question"=> $this->question,
            "correct_answer"=> $this->answer,
            "incorrect_answer"=> $incorrect_answer ,
            "difficulty_level"=> $this->difficulty_level,
            "question_time"=> $this->question_time,
            
        ];
    }
}
