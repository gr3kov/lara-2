<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Profile2Request extends FormRequest
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
          'telegram' => 'required',
          'telegram' => 'required',
          'phone' => 'required',
          'mailing' => 'required',
          'news_notification' => 'required',
          'firstname' => 'required',
          'patronymic' => 'required',
          'lastname' => 'required',
        ];
    }

    public function messages(){
        return [
          'required'=>'Поле :attribute обязательно для ввода',
          'min'     =>'Поле :attribute должно иметь минимум :min символов',
          'code.min'=>'Поле код должно содержать не менее :min символов',
          'email.required'=>'Email - обязательное поле',
          'email.exists'=>'Такого Email не существует'
        ];
    }
}
