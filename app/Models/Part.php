<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Option;

class Part extends Model
{
	public static $relationsArr = [
		'options' => ['value']
	];

	public static $accessorsArr = [
		'options_summary'
	];

	public function options()
	{
		return $this->belongsToMany(Option::class, 'part_options')->withPivot(self::$relationsArr['options']);
	}

	public function getOptionsSummaryAttribute()
	{
		$optionTypes = collect(Option::$types)->pluck('id', 'name')->toArray();

		foreach($this->options as $option) {

			switch($option->type) {
				case $optionTypes['info']:
					
					$arr[] = $option->values;
					break;

				case $optionTypes['select']:
					
					$json = json_decode($option->values);
					$arr[] = $json[$this->value] ?? null ;
					break;
			}

		}

		return implode(', ', $arr);
	}
}
