<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $datas = ['deleted_at'];
    protected $fillable = [
        'name',
        'address',
        'account_type',
        'shop_name',
        'contact_number',
        'email',
        'vat_number',
        'pan_number',
        'remark',
        'status',
    ];

    public function createUpdate($request)
    {
        $this->name = $request->name;
        $this->address = $request->address;
        $this->account_type = $request->accountType;
        $this->contact_number = $request->contactNumber;
        $this->email = $request->email;
        if ($request->accountType == 'retailer') {
            $this->shop_name = $request->shopName;
            $this->vat_number = $request->vat;
            $this->pan_number = $request->pan;
        }
        $this->save();
    }
}
