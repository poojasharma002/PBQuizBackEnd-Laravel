<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    use HasFactory;
    // fillable fields
    protected $fillable = [
        'video_code',
        'question',
        'option_one',
        'option_two',
        'option_three',
        'correct_answer',
        'difficulty_level',
        'tags',
        'music_code',
        'host',
        'question_time',
        'question_success_message',
        'question_fail_message',
        'deleted'
    ];
}
