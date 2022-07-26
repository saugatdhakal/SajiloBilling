<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getProductCode()
    {
        return Product::generateUniqueNumber();
    }

    public function getProductNameId(Request $request){

        $searchValue = trim($request->q) ?  trim($request->q) : "";
        $value="%$searchValue%";
        return DB::table('products')
        ->where('name', 'LIKE', $value)
        ->whereNull('deleted_at')
        ->skip(0)
        ->take(60)
        ->get(['id', 'name']);
    }

    public function create(ProductCreateUpdateRequest $request)
    {
        $product = new Product();
        $product->createUpdate($request);
        $response = [
            'status' => true,
            'message' => 'Product created successfully',
            'products' => $product
        ];
        return response($response, 201);
    }

    public function update(ProductCreateUpdateRequest $request,$id){
        $product = Product::find($id);
        $product->createUpdate($request);
        $response = [
            'status' => true,
            'message' => 'Product Updated successfully',
            'products' => $product
        ];
        return response($response, 201);
    }
    public function softDelete($id){
        $product = Product::find($id);
        $product->status = 'INACTIVE';
        $product->delete();
        $response = [
            'status' => true,
            'message' => 'Product soft deleted successfully',
            'products' => $product
        ];
        return response($response, 201);
    }
    public function restore($id)
    {

        $product = Product::onlyTrashed()->find($id);
        $product->status = 'ACTIVE';
        $product->restore();
        $response = [
            'status' => true,
            'message' => 'Product Successfully Restored ',
            'product' => $product
        ];
        return response($response, 201);
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->find($id)->forceDelete();
        $response = [
            'status' => true,
            'message' => 'product Successfully Deleted Permanently',
            'product' => $product
        ];
        return response($response, 201);
    }
    public function getProductDetails($id)
    {
        return DB::table('products')->where('id', $id)->first();
    }

    public function dataTables(Request $request)
    {
        return Product::getDataTable($request);
    }
}
