<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Part;

class Product extends Model
{

	public static $relationsArr = [
		'parts' => []
	];
	
	public function parts()
	{
		return $this->belongsToMany(Part::class, 'product_parts');
	}	

}
