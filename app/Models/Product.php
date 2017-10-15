<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Part;
use App\Models\Option;

class Product extends Model
{
	protected $fillable = ['name', 'category_id'];

	public static $relationsArr = [
		'parts' => [],
		'options' => ['value']
	];

	public static $accessorsArr = [

	];
	
	public function parts()
	{
		return $this->belongsToMany(Part::class, 'product_parts');
	}	

	public function options()
	{
		return $this->belongsToMany(Option::class, 'product_options');
	}	

}
