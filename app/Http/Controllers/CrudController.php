<?php

namespace App\Http\Controllers;

use App\Http\Traits\HelpersTrait;
use Illuminate\Http\Request;

class CrudController extends Controller
{
    use HelpersTrait;

    public function __construct(Request $request)
    {
        $this->modelName = 'App\\Models\\' . ucfirst(str_singular($request->segment(2)));
        $this->relations = isset($this->modelName::$relationsArr) ? array_keys($this->modelName::$relationsArr) : [];
    }

    public function index()
    {

        $items = $this->modelName::with($this->relations)->orderBy('id', 'desc')->take(20)->get();
        $items = $this->_getAllAccessors($items);

        $items = $this->_mergePivot($items->toArray());

        return response()->json($items);
    }

    public function store(Request $request)
    {

        $model = new $this->modelName;
        $fields = $request->only($model->getFillable());

        $model->fill($fields);
        $model->save();

        $this->_saveRelations($model, $request);

    }

    public function update($id, Request $request)
    {
        $model = $this->modelName::findOrFail($id);
        $fields = $request->only($model->getFillable());
        $model->fill($fields);
        $model->save();
        $this->_saveRelations($model, $request);
    }

    public function show($id)
    {

        $item = $this->modelName::with($this->relations)->findOrFail($id);
        $item = $this->_getAllAccessors([$item]);
        $item = $item[0]->toArray();
        $item = $this->_mergePivot([$item]);

        return response()->json($item[0]);
    }

    public function destroy($id)
    {
        $model = $this->modelName::findOrFail($id);
        $model->delete();
    }

}