<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use PDO;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $datas = ['deleted_at'];
    protected $fillables = ['name', 'unit', 'item_type', 'status', 'category_id'];

    public function createUpdate($request)
    {
        $this->name = $request->name;
        $this->unit = $request->unit;
        $this->item_type = $request->saleType;
        $this->category_id = $request->categoryId;
        $this->remark = $request->remark;
        $this->product_code = $request->productCode;
        if ($request->status) {
            $this->status = $request->status;
        }
        $this->save();
    }

    public static function generateUniqueNumber()
    {
        do {
            $code = random_int(100000, 999999);
        } while (Product::where("product_code", "=", $code)->first());
        return $code;
    }

    public static function getDataTable($request)
    {
        $isSoftDelete = $request->deleteData == 'true' ? true : false;
        //No of Columns
        $paginateNo = $request->paginate ?  $request->paginate : 10;

        $searchTerm = trim($request->search) ? trim($request->search) : '';

        $selectedTypes = $request->selectedType ? $request->selectedType : '';

        $product = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id');

        if (!$isSoftDelete) {
            $product = $product->whereNull('products.deleted_at');
        } else {
            $product = $product->whereNotNull('products.deleted_at');
        }
        $product = $product
            ->when(
                $selectedTypes,
                function ($query) use ($selectedTypes) {
                    $query->where('products.item_type', $selectedTypes);
                }
            )
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $term = "%$searchTerm%";
                $query->where(function ($query) use ($term) {
                    $query->where('products.name', 'like', $term)
                        ->orWhere('products.product_code', 'like', $term)
                        ->orWhere('products.unit', 'like', $term)
                        ->orWhere('products.item_type', 'like', $term)
                        ->orWhere('categories.name', 'like', $term);
                })->orderBy('products.created_at', 'DESC');
            })
            ->select(
                'products.id',
                'products.name as name',
                'categories.name as category',
                'products.unit as unit',
                'products.product_code as code',
                'products.item_type',
            )
            ->paginate($paginateNo);
        return $product;
    }
}
