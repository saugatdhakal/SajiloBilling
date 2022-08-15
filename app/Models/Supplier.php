<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'contact_number',
        'contact_person',
        'email',
        'remark',
        'status'
    ];

    public function supplierCreateUpdate($request)
    {
        $this->name = $request->name;
        $this->address = $request->address;
        $this->contact_number = $request->contact_number;
        $this->contact_person = $request->contact_person;
        $this->email = $request->email;
        $this->remark = $request->remark;
        $this->save();
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', $term)
                ->orWhere('address', 'like', $term)
                ->orWhere('contact_number', 'like', $term)
                ->orWhere('contact_person', 'like', $term)
                ->orWhere('email', 'like', $term)
                ->orWhere('remark', 'like', $term)
                ->orWhere('status', 'like', $term);
        })->orderBy('created_at', 'DESC');
    }
}
