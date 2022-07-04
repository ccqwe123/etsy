<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class Product extends Model
{
    protected $table = "products";
    protected $fillable = [
    	'store',
        'product_name',
        'price',
    	'profit',
    	'thumbnail',
    	'store',
        'product_link',
    	'supplier_link',
        'category_id',
        'status',
    ];
    public function categories()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
