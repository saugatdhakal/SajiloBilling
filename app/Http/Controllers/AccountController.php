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

    public function getAccounts(Request $request)
    {
        $paginateNo = $request->paginate ?  $request->paginate : 10;
        $searchTerm = $request->q ? $request->q : '';
        $selectedTypes = $request->selectedType ? $request->selectedType : '';
        if ($request->paginate == '-1') {
            $account = Account::when(
                $selectedTypes,
                function ($query) use ($selectedTypes) {
                    $query->where('account_type', $selectedTypes);
                }
            )->search(trim($searchTerm))->paginate(1000);
        } else {
            $account = Account::when(
                $selectedTypes,
                function ($query) use ($selectedTypes) {
                    $query->where('account_type', $selectedTypes);
                }
            )->search(trim($searchTerm))->paginate($paginateNo);
        }


        return response($account, 200);
    }
}
