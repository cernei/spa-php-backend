<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Part;

class Product extends Model
{
	protected $fillable = ['name', 'category_id'];

	public static $relationsArr = [
		'parts' => []
	];

	public static $accessorsArr = [

	];
	
	public function parts()
	{
		return $this->belongsToMany(Part::class, 'product_parts');
	}	

}
