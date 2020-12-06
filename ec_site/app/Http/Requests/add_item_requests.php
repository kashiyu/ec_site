<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class add_item_requests extends FormRequest
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
            'name'   => 'required',
            'price'  => 'bail |required |regex:/^[0-9]+$/ |digits_between:1,7',
            'stock'  => 'bail |required |regex:/^[0-9]+$/ |digits_between:1,7',
            'img'    => 'bail |required |image |mimes:jpeg,jpg,png',
            'status' => 'bail |required |boolean',
        ];
    }
    public function messages(){
        return [
            'name.required'   => '名前を入力してください。',

            'price.required'  => '値段を入力してください。',
            'price.regex'   => '値段は整数で入力してください',
            'price.digits_between'  => '値段は7桁以内で入力してください。',

            'stock.required' => '個数を入力してください。',
            'stock.regex'  => '個数は半角数字で入力してください',
            'stock.digits_between'  => '個数は7桁以内で入力してください。',

            'img.required'    => 'ファイルを選択してください',
            'img.image' => '指定されたファイルが画像ではありません。',
            'img.mimes' => 'ファイル形式が異なります。画像ファイルはJPEG又はPNGのみ利用可能です。',

            'status.required' => 'ステータスを入力してください。',
            'status.boolean' => '正しいステータスを入力してください。',
        ];
    }
}
