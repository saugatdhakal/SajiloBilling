<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'invoice_number',
        'transaction_date',
        'bill_date',
        'bill_no',
        'lr_no',
        'purchase_date',
        'gts',
        'total_amount',
        'discount_amount',
        'extra_charges',
        'rounding',
        'net_amount',
        'purchase_type',
        'remark',
        'status',
        'supplier_id',
        'created_by',
        'updated_by'

    ];
}
