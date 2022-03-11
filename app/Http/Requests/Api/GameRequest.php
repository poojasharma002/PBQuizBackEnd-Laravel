<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class GameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer',
            'game_id' => 'required|integer',
            'correct_answer' => 'required|integer',
            'incorrect_answer' => 'required|integer',
            // 'skipped_answer' => 'required|integer',
            'total_score' => 'required|integer',
            'total_questions' => 'required|integer',
            'game_date' => 'required|date',
            'game_time' => 'required|string',
        ];
    }
}
