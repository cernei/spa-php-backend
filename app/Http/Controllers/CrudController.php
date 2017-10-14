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
        $this->relations = isset($this->modelName::$relationsArr) ? array_keys($this->modelName::$relationsArr) : [];
    }
    
    public function index()
    {

        $items = $this->modelName::with($this->relations)->orderBy('id','desc')->take(10)->get();
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

    public function _getAllAccessors($items)
    {

        if ($this->modelName::$accessorsArr) {
            foreach ($this->modelName::$accessorsArr as $value) {
                foreach($items as &$item) {
                    $item->$value = $item->{camel_case($value)};
                }
                
            }
        }
        return $items;
    }

    public function _mergePivot($items)
    {
        if ($this->relations) {
            // model defined list of relations
            foreach ($this->relations as $relation) {
                if ($items) {
                    // items from DB
                    foreach($items as &$item) {

                        if ($item[$relation]) {
                            foreach($item[$relation] as &$relation_item) {
                                
                                if ( isset($relation_item['pivot']) ) {
                                    $relation_item = $relation_item + $relation_item['pivot'];
                                    unset($relation_item['pivot']);
                                }
                            }
                            unset($relation_item);
                        }
                    }
                    unset($item);
                }
            }
        }

        return $items;
    }

    public function destroy($id)
    {
        $model = $this->modelName::findOrFail($id);
        $model->delete();
    }

    protected function _saveRelations($model, $request)
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