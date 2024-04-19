<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
            'shop_name' => ['required','string','max:50'],
            'shop_area' => ['required'],
            'shop_genre' => ['required'],
            'shop_comment' => ['required','string','max:400'],
            'shop_photo' => ['required','image','mimes:jpeg,jpg,png']
        ];
    }

    public function messages()
    {
        return [
            'shop_name.required' => '店舗名を入力してください',
            'shop_name.max' => '店舗名は50文字以内で入力してください',
            'shop_name.string' => '店舗名は文字列で入力してください',
            'shop_area.required' => '地域を選択してください',
            'shop_genre.required' => 'ジャンルを選択してください',
            'shop_comment.required' => '店舗概要を入力してください',
            'shop_comment.string' => '店舗概要は文字列で入力してください',
            'shop_comment.max' => '店舗概要は400文字以内で入力してください',
            'shop_photo.required' => '店舗画像を選択してください',
            'shop_photo.image' => '画像ファイルを選択してください',
            'shop_photo.mines' => 'JPEGまたはPNG形式の画像を入力してください',

        ];
    }
}
