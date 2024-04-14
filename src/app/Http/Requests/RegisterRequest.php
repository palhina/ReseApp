<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use App\Models\User;


class RegisterRequest extends FormRequest
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
            'name' => ['required','max:191'],
            'email' => ['required','email','unique:users,email','unique:admins,email','unique:managers,email','max:191'],
            'password' => ['required','min:8','max:191']
        ];
    }
    public function messages()
    {
        return [
        'name.required' => '名前を入力してください',
        'name.max' => '名前は191文字以下で入力してください',
        'email.required' => 'メールアドレスを入力してください',
        'email.email' => 'メールアドレスを入力してください',
        'email.unique' => 'このメールアドレスは既に登録されています',
        'email.max' => 'メールアドレスは191文字以下で入力してください',
        'password.required' => 'パスワードを入力してください',
        'password.min' => 'パスワードは8文字以上191文字以下で入力してください',
        'password.max' => 'パスワードは8文字以上191文字以下で入力してください'
        ];
    }
}
