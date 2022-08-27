<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProductCode(){
        return Product::generateUniqueNumber();
    }

    public function create(ProductCreateUpdateRequest $request){
        $product = new Product();
        $product->createUpdate($request);
        $response =[
            'status' => true,
            'message' =>'Product created successfully',
            'products' =>$product
        ];
        return response($response,201);
    }

}
