<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'role' => 'required',
            'id_user' => 'required',
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/',
            'confirm_password' => 'required|same:password',
        ];
    }
}
