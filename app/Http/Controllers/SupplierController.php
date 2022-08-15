<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\SuppierCreateUpdateRequest;
use Illuminate\Support\Facades\DB;


class SupplierController extends Controller
{
    public function create(SuppierCreateUpdateRequest $request)
    {
        $supplier = new Supplier();
        $supplier->supplierCreateUpdate($request);
        $response = [
            'status' => true,
            'message' => 'Supplier created successfully',
            'supplier' => $supplier
        ];
        return response($response, 201);
    }

    public function getSupplierDeatils(Request $request)
    {
        //No of Columns
        $paginateNo = $request->paginate ?  $request->paginate : 10;

        $searchTerm = $request->search ? $request->search : '';



        $supplier = DB::table('suppliers')->when($searchTerm, function ($query) use ($searchTerm) {
            $term = "%$searchTerm%";
            $query->where(function ($query) use ($term) {
                $query->where('name', 'like', $term)
                    ->orWhere('address', 'like', $term)
                    ->orWhere('contact_number', 'like', $term)
                    ->orWhere('contact_person', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('remark', 'like', $term)
                    ->orWhere('status', 'like', $term);
            })->orderBy('created_at', 'DESC');
        })->paginate($paginateNo);

        $account = Supplier::search(trim($searchTerm))->paginate($paginateNo);
        return $supplier;
    }
}
