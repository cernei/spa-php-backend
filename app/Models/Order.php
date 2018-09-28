<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Order extends Model
{

    public static $relationsArr = [
        'products' => ['qty', 'size']
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')->withPivot(self::$relationsArr['products']);
    }

}
