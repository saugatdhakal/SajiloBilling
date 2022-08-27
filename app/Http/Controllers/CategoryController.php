<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class CategoryController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->save();
        $response = [
            'status' => true,
            'message' => "Category created successfully",
            'category' => $category
        ];
        return response($response, 201);
    }

    public function getCategories()
    {
        return json_decode(DB::table('categories')->get(['id', 'name']));
    }

    public function getSearchCategories(Request $request)
    {
        $searchValue = trim($request->q) ?  trim($request->q) : "";
        $value = "%$searchValue%";
        return DB::table('categories')->where('name', 'LIKE', $value)->skip(0)
            ->take(300)->get(['id', 'name']);
    }
}
