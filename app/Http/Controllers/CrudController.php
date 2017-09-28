<?php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class CrudController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

    public function __construct(Request $request)
    {
        $this->modelName = 'App\\Models\\' . ucfirst(str_singular($request->segment(2)));
    }
    
    public function index()
    {

        $items = $this->modelName::orderBy('id','desc')->take(10)->get();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        
        $model = new $this->modelName;
        $fields = $request->only($model->getFillable());
        
        $model->fill($fields);
        $model->save();

        $this->handleRelations($model, $request);
        
    }

    public function update($id, Request $request)
    {
        $model = $this->modelName::findOrFail($id);
        $fields = $request->only($model->getFillable());
        $model->fill($fields);
        $model->save();
        $this->handleRelations($model, $request);
    }    

    public function show($id)
    {
        $relations = isset($this->modelName::$relationsArr) ? array_keys($this->modelName::$relationsArr) : [];
        $model = $this->modelName::with($relations)->findOrFail($id);
        $items = $model->toArray();
        if ($relations) {
            foreach ($relations as $relation) {
                if ($items[$relation]) {
                    foreach($items[$relation] as &$relation_item) {
                        if ( isset($relation_item['pivot']) ) {
                            $relation_item = $relation_item + $relation_item['pivot'];
                            unset($relation_item['pivot']);
                        }
                    }
                    unset($relation_item);
                }
            }
        }
        return response()->json($items);
    }

    public function destroy($id)
    {
        $model = $this->modelName::findOrFail($id);
        $model->delete();
    }

    protected function handleRelations($model, $request)
    {
        $relations = $request->all();
        if ($relations) {
            foreach ($relations as $relation => $items) {
                if (method_exists($model, $relation)) {
                    $new_items = [];
                    foreach($items as $value) {
                        $new_items[$value['id']] = array_only($value, $model::$relationsArr[$relation]);
                    }
                    $model->{$relation}()->sync($new_items);
                }
            }
        }
    }

}