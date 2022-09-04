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

    public function create(Request $request){
        $purchase = new Purchase();
        DB::transaction(function()use($request,$purchase){
        $purchase->createUpdate($request);//Model
        increasePurchaseBilling(); //Helper (Config purchase Invoice No)
        });
        $response= [
            'status' =>true,
            'message'=>'Purchase created successfully',
            'purchase'=>$purchase
        ];
        return $response;
    }

}
