<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class login_requests extends FormRequest
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
    public function rules(){
        return [
            'user_name'  => 'required',
            'password'  => 'required',
            
        ];
    }

    public function messages(){
        return [
            'user_name.required' => 'ユーザー名を入力してください。',
            'password.required' => 'パスワードを入力してください。',
        ];
    }
}
