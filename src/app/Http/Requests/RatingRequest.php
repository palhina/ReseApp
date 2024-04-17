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
            'rating' => ['required','in:1,2,3,4,5'],
            'comment' => ['nullable','max:400','string'],
            'rating_img' => ['nullable','image','mimes:jpeg,png','max:2000']
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => '評価を入力してください',
            'rating.in' => '評価は1～5で入力してください',
            'comment.max' => 'コメントは400文字以下で入力してください',
            'comment.string' => 'コメントは文字列で入力してください',
            'rating_img.image' => 'JPEGまたはPNG形式の画像を入力してください',
            'rating_img.mimes' => 'JPEGまたはPNG形式の画像を入力してください',
        ];
    }
}
