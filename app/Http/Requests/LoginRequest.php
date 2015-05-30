<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 30.5.15
 * Time: 20:26
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'username' => 'required',
            'password' => 'required',
        ];
    }

    public function authorize()
    {
        return true;
    }
}