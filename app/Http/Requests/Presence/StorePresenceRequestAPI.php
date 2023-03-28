<?php

namespace App\Http\Requests\Presence;

use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StorePresenceRequestAPI extends FormRequest
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
            'check_in_time' => 'required|date',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            // 'detail' => 'required',
            // 'attachment' => 'required|mimes:xls,xlsx,doc,docx,pdf,jpeg,jpg,png|max:4096',
        ];
    }
}
