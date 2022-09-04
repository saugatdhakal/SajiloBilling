<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseCreateUpdate extends FormRequest
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
            'invoiceNumbers' => 'required',
            'billNumber' => 'required|max:10',
            'billDate'=> 'required',
            'transactionDate'=>'required',
            'lrNo'=> 'nullable',
            'supplierId'=> 'required',
            'remark'=> 'nullable|max:255',
        ];
    }
}
