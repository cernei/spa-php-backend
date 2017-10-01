<?php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends CrudController
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

    public function index() {
        $products = Product::with(['parts','parts.options'])->get();
        return response()->json($products);
    }


}