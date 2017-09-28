<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomainRecord extends Model
{
	protected $fillable = ['name', 'type', 'content', 'ttl', 'prio'];

}
