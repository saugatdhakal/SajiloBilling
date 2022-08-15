<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuppierCreateUpdateRequest extends FormRequest
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
            'name' => 'required|string',
            'address' => 'required|string',
            'contact_number' => 'required|numeric',
            'contact_person' => 'nullable|string',
            'email' => 'required|email',
            'remark' => 'nullable|max:255',
        ];
    }
}
