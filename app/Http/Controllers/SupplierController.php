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

    public function edit($id)
    {
        if (!$id) return ['status' => false, 'message' => 'id is required'];
        $supplier = DB::table('suppliers')->where('id', $id)->first();
        return $supplier;
    }

    public function update(SuppierCreateUpdateRequest $request, $id)
    {
        $supplier = Supplier::find($id);
        $supplier->supplierCreateUpdate($request);
        $response = [
            'status' => true,
            'message' => 'Supplier Edited successfully',
            'supplier' => $supplier
        ];
        return response($response, 201);
    }
    public function softDelete($id)
    {
        if (!$id) return ['status' => false, 'message' => 'id is required'];
        $supplier = Supplier::find($id);
        $supplier->status = 'INACTIVE';
        $supplier->delete();
        $response = [
            'status' => true,
            'message' => 'supplier soft deleted successfully',
            'supplier' => $supplier
        ];
        return response($response, 201);
    }
    //Pagination of softdelete dashboard
    public function getSoftDeleteSuppliers(Request $request)
    {
        //No of Columns
        $paginateNo = $request->paginate ?  $request->paginate : 10;

        $searchTerm = trim($request->search) ? trim($request->search) : '';

        $supplier = DB::table('suppliers')->whereNotNull('deleted_at')->when($searchTerm, function ($query) use ($searchTerm) {
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
        return $supplier;
    }

    //Pagination of Supplier Dashboards
    public function getSupplierDeatils(Request $request)
    {
        //No of Columns
        $paginateNo = $request->paginate ?  $request->paginate : 10;

        $searchTerm = trim($request->search) ? trim($request->search) : '';

        $supplier = DB::table('suppliers')->where('deleted_at', null)->when($searchTerm, function ($query) use ($searchTerm) {
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
        return $supplier;
    }
    public function forceDeleteSupplier($id)
    {
        if (!$id) {
            $response = [
                'status' => false,
                'message' => 'supplier id is required',
            ];
            return response($response, 400);
        }
        $supplier = Supplier::onlyTrashed()->find($id)->forceDelete();
        $response = [
            'status' => true,
            'message' => 'Supplier Successfully Deleted Permanently',
            'supplier' => $supplier
        ];
        return response($response, 201);
    }

    public function restoreSupplier($id)
    {
        if (!$id) {
            $response = [
                'status' => false,
                'message' => 'supplier id is required',
            ];
            return response($response, 400);
        }
        $supplier = Supplier::onlyTrashed()->find($id);
        $supplier->status = 'ACTIVE';
        $supplier->restore();
        $response = [
            'status' => true,
            'message' => 'Supplier Successfully Restored ',
            'supplier' => $supplier
        ];
        return response($response, 201);
    }
}
