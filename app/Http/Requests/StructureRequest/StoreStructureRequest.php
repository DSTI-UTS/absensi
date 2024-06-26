<?php

namespace App\Http\Requests\StructureRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreStructureRequest extends FormRequest
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
            'role' => ['required', 'string'],
            'parent_id' => ['required'],
            'type' => ['required', 'in:struktural,fakultas,prodi,dosen']
        ];
    }
}
