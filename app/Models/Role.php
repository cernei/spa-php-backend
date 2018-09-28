<?php

namespace App;


class Role extends Model
{

    public static $relationsArr = [
        'roles' => [],
    ];

    public static $accessorsArr = [

    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }
}
