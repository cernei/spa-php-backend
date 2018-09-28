<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['name'];

    public static $accessorsArr = [

    ];

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'product_stores');
    }

}
