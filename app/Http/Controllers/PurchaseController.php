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

    public function getPurchaseDetails($id){
       return DB::table('purchases')->find($id);
    }
    public function create(PurchaseCreateUpdate $request){
        $purchase = new Purchase();
        DB::transaction(function()use($request,$purchase){
        $purchase->createUpdate($request);//Model
        increasePurchaseBilling(); //Helper (Config purchase Invoice No)
        });
        $response= [
            'status' =>true,
            'message'=>'Purchase created Successfully',
            'purchase'=>$purchase
        ];
        return $response;
    }

    public function update(PurchaseCreateUpdate $request,$id){
        $purchase = Purchase::find($id);
        $purchase->createUpdate($request);//Model
        $response= [
            'status' =>true,
            'message'=>'Purchase Updated Successfully',
            'purchase'=>$purchase
        ];
        return $response;

    }

    public function getDatatable(Request $request){
       return Purchase::datatable($request);
    }

}
