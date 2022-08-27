<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PDO;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $datas = ['deleted_at'];
    protected $fillables = ['name', 'unit', 'item_type', 'status', 'category_id'];

    public function createUpdate($request){
        $this->name = $request->name;
        $this->unit = $request->unit;
        $this->item_type = $request->saleType;
        $this->category_id = $request->categoryId;
        $this->remark = $request->remark;
        $this->product_code = $request->productCode;
        if($request->status){
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

}
