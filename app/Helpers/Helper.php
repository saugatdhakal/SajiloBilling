<?php

use App\Models\Config;
use Illuminate\Support\Facades\DB;

if (!function_exists('getFiscalYear')) {
    function getFiscalYear()
    {
        $fiscal = DB::table('configs')->get('fiscal_year')->first();
        $split = str_split($fiscal->fiscal_year, 2);
        return "0$split[0]/0$split[1]"; //078/079
    }
}

if (!function_exists('getPurchaseInvoice')) {
    function getPurchaseInvoice()
    {
        $purchaseInvoice = DB::table('configs')->get('purchase_bill_number')->first();
        $fiscal_year = getFiscalYear();
        $num = str_pad($purchaseInvoice->purchase_bill_number, 5, '0', STR_PAD_LEFT);
        $invoice = "$fiscal_year/$num"; //078/079/00001
        return $invoice;
    }
}
if (!function_exists('increasePurchaseBilling')) {
    function increasePurchaseBilling()
    {
        $purchaseInvoice = Config::first();
        $purchaseInvoice->purchase_bill_number = $purchaseInvoice->purchase_bill_number + 1;
        $purchaseInvoice->save();
    }
}


if (!function_exists('getSalesReturnInvoice')) {
    function getSalesReturnInvoice()
    {
        $saleReturnInvoice = DB::table('configs')->get('sales_return_bill_number')->first();
        $fiscal_year = getFiscalYear();
        $num = str_pad($saleReturnInvoice->sales_return_bill_number, 5, '0', STR_PAD_LEFT);
        $invoice = "0$fiscal_year[0]/0$fiscal_year[1]/$num";
        return $invoice;
    }
}

if (!function_exists('getSalesInvoice')) {
    function getSalesInvoice()
    {
        $saleInvoice = DB::table('configs')->get('sales_bill_number')->first();
        $fiscal_year = getFiscalYear();
        $num = str_pad($saleInvoice->sales_bill_number, 5, '0', STR_PAD_LEFT);
        $invoice = "0$fiscal_year[0]/0$fiscal_year[1]/$num";
        return $invoice;
    }
}
