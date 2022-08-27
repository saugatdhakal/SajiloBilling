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
    public function dataTables(Request $request)
    {
        return Product::getDataTable($request);
    }
}
