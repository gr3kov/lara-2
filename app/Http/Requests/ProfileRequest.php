<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
          'telegram' => 'required',
          'phone' => 'required',
          'mailing' => 'required',
          'news_notification' => 'required',
          'firstname' => 'required',
          'patronymic' => 'required',
          'lastname' => 'required',
        ];
    }
}
