<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $datas=['deleted_at'];
    protected $fillable=[
        'name',
        'address',
        'contact_number',
        'email',
        'vat_number',
        'pan_number',
        'remark',
        'status',
    ];
}
