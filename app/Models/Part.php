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

	public function getOptionsSummaryAttribute() {

		foreach($this->options as $option) {

			if ($option->type === 1) {
				$arr[] = $option->values;
			} else if ($option->type === 2) {
				$json = json_decode($option->values);

				$arr[] = $json[$this->value] ?? null ;
			}
		}

		return implode(', ', $arr);
	}
}
