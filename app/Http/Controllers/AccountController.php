<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AccountCreateUpdateRequest;


class AccountController extends Controller
{
    public function createAccount(AccountCreateUpdateRequest $request)
    {
        $account = new Account();
        $account->createUpdate($request);
        $response = [
            'status' => true,
            'message' => 'Account created successfully',
            'account' => $account
        ];
        return response($response, 201);
    }

    public function updateAccount(AccountCreateUpdateRequest $request, $id)
    {
        $account = Account::find($id);
        $account->createUpdate($request);
        $response = [
            'status' => true,
            'message' => 'Account Updated Successfully',
            'account' => $account
        ];

        return response($response, 201);
    }


    //Pagination
    public function getAccounts(Request $request)
    {
        //No of Columns
        $paginateNo = $request->paginate ?  $request->paginate : 10;

        //Search text
        $searchTerm = $request->q ? $request->q : '';

        //Select type(ratilers)
        $selectedTypes = $request->selectedType ? $request->selectedType : '';

        //if user select all columns to be shown
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

    public function getSoftDeleteAccounts(Request $request)
    {
        //No of Columns
        $paginateNo = $request->paginate ?  $request->paginate : 10;

        //Search text
        $searchTerm = $request->q ? $request->q : '';

        //Select type(ratilers)
        $selectedTypes = $request->selectedType ? $request->selectedType : '';

        //if user select all columns to be shown
        if ($request->paginate == '-1') {
            $account = Account::onlyTrashed()->when(
                $selectedTypes,
                function ($query) use ($selectedTypes) {
                    $query->where('account_type', $selectedTypes);
                }
            )->search(trim($searchTerm))->paginate(1000);
        } else {
            $account = Account::onlyTrashed()->when(
                $selectedTypes,
                function ($query) use ($selectedTypes) {
                    $query->where('account_type', $selectedTypes);
                }
            )->search(trim($searchTerm))->paginate($paginateNo);
        }
        return response($account, 200);
    }


    public function softDeleteAccount($id)
    {
        if (!$id) {
            $response = [
                'status' => false,
                'message' => 'account id is required',
            ];
            return response($response, 400);
        }
        $account = Account::find($id);
        $account->delete();
        $response = [
            'status' => true,
            'message' => 'account has successfully been deleted',
            'account' => $account
        ];
        return response($response, 200);
    }

    public function forceDeleteAccount($id)
    {
        if (!$id) {
            $response = [
                'status' => false,
                'message' => 'account id is required',
            ];
            return response($response, 400);
        }
        $account = Account::onlyTrashed()->find($id)->forceDelete();

        $response = [
            'status' => true,
            'message' => 'account has permanently been deleted',
            'account' => $account
        ];
        return response($response, 200);
    }


    public function getAccountDetails($id)
    {
        $account = Account::withTrashed()->find($id);
        return response($account, 200);
    }
}
