<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
	protected $fillable = ['name', 'description', 'type', 'values'];

    const TYPES = [
    	'input',
    	'info',
    	'checkbox',
    	'dropdown',
    ];
}
