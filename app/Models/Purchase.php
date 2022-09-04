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
    public  function createUpdate($request){
        $this->invoice_number = $request->invoiceNumbers;
        $this->supplier_id = $request->supplierId;
        $this->fiscal_year = getFiscalYear();
        $this->bill_no = $request->billNumber;
        $this->transaction_date = $request->transactionDate;
        $this->bill_date = $request->billDate;
        $this->lr_no = $request->lrNo ? $request->lrNo : null ;
        $this->remark = $request->remark ? $request->remark : null;
        $this->save();
    }
}
