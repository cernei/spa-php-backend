<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Option;

class Part extends Model
{
	protected $fillable = ['name'];

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

		$arr = [];
		


		foreach($this->options as $option) {

			switch($option->type) {
				case $optionTypes['info']:
					
					$arr[] = $option->values;
					break;

				case $optionTypes['checkbox']:
				case $optionTypes['select']:

					$json = json_decode($option->values, true);

					$arr[] = $json[$option->pivot->value] ? $option->name . ': ' . $json[$option->pivot->value]  : null ;
					break;
			}

		}

		if ($arr) return implode(', ', $arr);
	}
}
