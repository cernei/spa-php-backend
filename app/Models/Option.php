<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['name', 'description', 'type', 'values'];

    public static $accessorsArr = [

    ];

    public static $types = [
        ['id' => '1', 'name' => 'info'],
        ['id' => '2', 'name' => 'info_arr'],
        ['id' => '3', 'name' => 'input'],
        ['id' => '4', 'name' => 'checkbox'],
        ['id' => '5', 'name' => 'select'],
        ['id' => '6', 'name' => 'multi_select'],
    ];
}
