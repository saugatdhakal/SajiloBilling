<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AccountController extends Controller
{
    public function createAccount(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'contactNumber' => 'required',
            'accountType' => 'required'

        ]);
        if ($request->accountType == 'retailer') {
            $request->validate([
                'vat' => 'required',
                'pan' => 'required',
                'shopName' => 'required'
            ]);
        }

        $account = new Account();
        $account->createUpdate($request);
        $response = [
            'status' => true,
            'message' => 'Account created successfully',
            'account' => $account
        ];

        return response($response, 201);
    }

    public function getAccounts() {
        return DB::table('users')->get();
    }

}
