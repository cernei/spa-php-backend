<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Option;

class BatchController extends Controller
{
    public function index(Request $request)
    {
        $response = [];
        $allowedForBatch = ['categories', 'options', 'parts', 'currencies', 'stores', 'groups'];
        $globals = [
            'option_types' => Option::$types,
            'active_or_disabled' => [
                ['id' => '1', 'name' => 'Active'],
                ['id' => '2', 'name' => 'Disabled']
            ]
        ];

        $batch = explode(',', $request->input('arr'));
        $batch = array_unique($batch);

        foreach ($batch as $modelName) {
            if (in_array($modelName, $allowedForBatch)) {
                $model = 'App\\Models\\' . ucfirst(str_singular($modelName));

                $items = $model::take(20)->get();

                $response[$modelName] = $items;
            } elseif ($globals[$modelName]) {
                $response[$modelName] = $globals[$modelName];
            }
        }

        return response()->json($response);
    }


}