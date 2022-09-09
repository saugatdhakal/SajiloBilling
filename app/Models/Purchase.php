<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
    public static function datatable($request)
    {
        $isSoftDelete = $request->deleteData == 'true' ? true : false;
        //No of Columns
        $paginateNo = $request->paginate ?  $request->paginate : 10;

        $searchTerm = trim($request->search) ? trim($request->search) : '';

        $selectedTypes = $request->selectedType ? $request->selectedType : '';

        $purchase = DB::table('purchases')
            ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id');

        if (!$isSoftDelete) {
            $purchase = $purchase->whereNull('purchases.deleted_at');
        } else {
            $purchase = $purchase->whereNotNull('purchases.deleted_at');
        }
        $purchase = $purchase
            ->when(
                $selectedTypes,
                function ($query) use ($selectedTypes) {
                    $query->where('purchases.status', $selectedTypes);
                }
            )
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $term = "%$searchTerm%";
                $query->where(function ($query) use ($term) {
                    $query->where('suppliers.name', 'like', $term)
                        ->orWhere('purchases.invoice_number', 'like', $term)
                        ->orWhere('purchases.transaction_date', 'like', $term)
                        ->orWhere('purchases.bill_date', 'like', $term)
                        ->orWhere('purchases.net_amount', 'like', $term)
                        ->orWhere('purchases.status', 'like', $term)
                        ->orWhere('purchases.bill_no', 'like', $term);
                })->orderBy('purchases.created_at', 'DESC');
            })
            ->select(
                'purchases.id',
                'suppliers.name as supplier_name',
                'purchases.invoice_number',
                'purchases.transaction_date',
                'purchases.bill_date',
                'purchases.bill_no',
                'purchases.net_amount',
                'purchases.status'
            )
            ->paginate($paginateNo);
        return $purchase;
    }
}
