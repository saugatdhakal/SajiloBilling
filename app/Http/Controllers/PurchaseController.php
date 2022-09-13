<?php

namespace App\Http\Controllers;

use App\Http\Requests\Purchase\PurchaseCreateUpdate;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function purchaseInvoice()
    {
        return getPurchaseInvoice(); //number
    }
    public function viewPurchaseDetails($id)
    {
        return DB::table('purchases AS pur')
            ->where('pur.id', $id)
            ->join('suppliers AS sup', 'pur.supplier_id', '=', 'sup.id')
            ->select(
                'pur.id',
                'sup.name as supplier_name',
                'pur.invoice_number',
                'pur.transaction_date',
                'pur.bill_date',
                'pur.bill_no',
                'pur.lr_no',
                'pur.total_amount'
            )
            ->first();
    }

    public function getPurchaseDetails($id)
    {
        return DB::table('purchases')->find($id);
    }
    public function create(PurchaseCreateUpdate $request)
    {
        $purchase = new Purchase();
        DB::transaction(function () use ($request, $purchase) {
            $purchase->createUpdate($request); //Model
            increasePurchaseBilling(); //Helper (Config purchase Invoice No)
        });
        $response = [
            'status' => true,
            'message' => 'Purchase created Successfully',
            'purchase' => $purchase
        ];
        return $response;
    }

    public function update(PurchaseCreateUpdate $request, $id)
    {
        $purchase = Purchase::find($id);
        $purchase->createUpdate($request); //Model
        $response = [
            'status' => true,
            'message' => 'Purchase Updated Successfully',
            'purchase' => $purchase
        ];
        return $response;
    }

    public function softDelete($id)
    {
        $purchase = Purchase::find($id);

        $purchase->delete();
        $response = [
            'status' => true,
            'message' => 'purchase soft deleted successfully',
            'purchases' => $purchase
        ];
        return response($response, 201);
    }
    public function restore($id)
    {
        $purchase = Purchase::onlyTrashed()->find($id);
        $purchase->restore();
        $response = [
            'status' => true,
            'message' => 'purchase Successfully Restored ',
            'purchase' => $purchase
        ];
        return response($response, 201);
    }

    public function forceDelete($id){
        $purchase = Purchase::onlyTrashed()->find($id)->forceDelete();
        $response = [
            'status' => true,
            'message' => 'Purchase Detail Deleted Permanently',
            'purchase' => $purchase
        ];
        return response($response, 201);
    }


    public function getDatatable(Request $request)
    {
        return Purchase::datatable($request);
    }
}
