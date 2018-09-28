<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Part;
use App\Models\Option;
use App\Models\Store;

class Product extends Model
{
    protected $fillable = ['name', 'category_id'];

    public static $relationsArr = [
        'parts' => [],
        'options' => ['value'],
        'stores' => ['price', 'is_active'],
    ];

    public static $accessorsArr = [

    ];

    public function parts()
    {
        return $this->belongsToMany(Part::class, 'product_parts');
    }

    public function options()
    {
        return $this->belongsToMany(Option::class, 'product_options')->withPivot(self::$relationsArr['options']);
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'product_stores')->withPivot(self::$relationsArr['stores']);
    }

}
