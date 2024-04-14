<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
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
            'rating' => ['required'],
            'comment' => ['nullable','max:1000','string']
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => '評価を入力してください',
            'comment.max' => 'コメントは1000文字以下で入力してください',
            'comment.string' => 'コメントは文字列で入力してください',
        ];
    }
}
