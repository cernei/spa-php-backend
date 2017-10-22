<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Option;
use App\Models\Store;

class GlobalsController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

    public function index() {

        $arr = [
            'product_types' => [
                ['id' => '1', 'name' => 'Meals'],
                ['id' => '2', 'name' => 'Snaks and Drinks'],
            ],

            'option_types' => Option::$types,

            'active_or_disabled' => [
                ['id' => '1', 'name' => 'Active'],
                ['id' => '2', 'name' => 'Disabled'],
            ],

            'stores' => Store::all(),
        ];

        return response()->json($arr);
    }


}