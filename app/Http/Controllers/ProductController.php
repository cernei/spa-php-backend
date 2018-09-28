<?php

namespace App\Http\Controllers;

use App\Http\Traits\HelpersTrait;
use App\Models\Product;

class ProductController extends CrudController
{
    public function index()
    {
        $products = Product::with(['parts', 'parts.options'])->get();
        return response()->json($products);
    }


}