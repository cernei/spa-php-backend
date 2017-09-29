<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Option;

class Part extends Model
{
	public static $relationsArr = [
		'options' => ['value']
	];

	public function options()
	{
		return $this->belongsToMany(Option::class, 'part_options')->withPivot(self::$relationsArr['options']);
	}
}
