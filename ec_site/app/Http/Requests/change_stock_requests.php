<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class change_stock_requests extends FormRequest
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
            'stock'  => 'bail |required |regex:/^[0-9]+$/ |digits_between:1,7',
        ];
    }

    public function messages(){
        return [
            'stock.required' => '個数を入力してください。',
            'stock.regex'  => '個数は整数で入力してください',
            'stock.digits_between'  => '個数は7桁以内で入力してください。',
        ];
    }
}
