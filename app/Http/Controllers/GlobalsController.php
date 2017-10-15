<?php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Option;

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
            'option_types' => Option::$types,
        ];

        return response()->json($arr);
    }


}