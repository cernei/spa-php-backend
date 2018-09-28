<?php

namespace App\Http\Traits;

trait HelpersTrait
{
    public function _getAllAccessors($items)
    {

        if (property_exists($this->modelName, 'accessorsArr') && $this->modelName::$accessorsArr) {
            foreach ($this->modelName::$accessorsArr as $value) {
                foreach ($items as &$item) {
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
                    foreach ($items as &$item) {

                        if ($item[$relation]) {
                            foreach ($item[$relation] as &$relation_item) {

                                if (isset($relation_item['pivot'])) {
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

    protected function _saveRelations($model, $request)
    {
        $relations = $request->all();
        if ($relations) {
            foreach ($relations as $relation => $items) {
                if (method_exists($model, $relation)) {
                    $new_items = [];
                    foreach ($items as $value) {
                        $new_items[$value['id']] = array_only($value, $model::$relationsArr[$relation]);
                    }
                    $model->{$relation}()->sync($new_items);
                }
            }
        }
    }
}