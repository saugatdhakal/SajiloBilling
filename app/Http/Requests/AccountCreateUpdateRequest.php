<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountCreateUpdateRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'contactNumber' => 'required|min:10|max:10',
            'accountType' => 'required|in:retailer,individual',
            'vat' => 'required_if:list_type,==,retailer|nullable|min:8|max:8',
            'pan' => 'required_if:list_type,==,retailer|nullable|min:8|max:8',
            'shopName' => 'required_if:list_type,==,retailer|nullable'
        ];
    }
}
