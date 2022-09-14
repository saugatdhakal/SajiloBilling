<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;
    protected $fillable=[
        'quantity',
        'amount',
        'discount_percent',
        'discount_amount',
        'wholesale_price',
        'margin_per_item',
        'margin_total',
        'purchase_item_type',
        'product_id',
        'purchase_id',
    ];
}
