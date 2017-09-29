<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Part;

class Product extends Model
{

	public function parts()
	{
		return $this->belongsToMany(Part::class, 'product_parts');
	}	

}
