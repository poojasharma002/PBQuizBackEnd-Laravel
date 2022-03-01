<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class QuestionRequest extends FormRequest
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
            //define the validation rules here
            'video_code' => 'required',
            'question' => 'required',
            'option_one' => 'required',
            'option_two' => 'required',
            'option_three' => 'required',
            'question_time' => 'required|min:1|integer'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * 
     * 
     * 
     *
     */
    //   public function messages()
    //   {
    //      return [
    //         'video_code.required' => 'Video Code is required',
    //        'question.required' => 'Question is required',
    //       'option_one.required' => 'Option One is required',
    //      'option_two.required' => 'Option Two is required'
    //     ];
    // }


     
}
