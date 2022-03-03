<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class statistics extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'game_id','correct_answer','incorrect_answer','skipped_question','total_score','total_questions','game_won','trophy_won','star_won','game_date','game_time'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}




?>
