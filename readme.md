## spa-php-backend
A REST API backend on Laravel.

#### Features
 - Easy addition of new entities.
 - Nested one-to-many relations
 - merging pivot table columns
 - Including accessors into result 
 
#### New entity
``` php
// rotues/api.php 
Route::middleware('api')->resource('categories', 'CrudController');


// app/Models/Category.php
class Category extends Model
{

}
```
That's it. Your resource endpoints for ```categories``` are ready.

#### Include relations
In order to include relations into single record endpoint (```entity/:id```) do this:
``` php
// app/Models/User.php
...
public static $relationsArr = [
    'groups' => ['pivot_column1']
];

public function groups()
{
    return $this->belongsToMany(Group::class, 'user_groups');
}
...
```
And now your result would be like this:
```
{
    "id":1,
    "name":"user",
    "email":"user@gmail.com",
    "created_at":"2018-09-28 16:16:05",
    "updated_at":"2018-09-28 16:16:05",
    "groups": [
        {
            "id":1,
            "name":"Administrators",
            "created_at":"2018-09-28 16:16:05",
            "updated_at":"2018-09-28 16:16:05",
            "pivot_column1": 3
        }
    ]
}
```
If you designed addtional pivot columns in your table you can specify them in an array. (See ```pivot_column1```)

#### Accessors
You can include accessors into result by specifying their names.

``` php
// app/Models/User.php

...
public static $accessorsArr = [
    'hello'
];

public function getHelloAttribute()
{
    return 'Hello';
}
...
```
You will get:

```
{
    "id":1,
    "name":"user",
    "email":"user@gmail.com",
    "created_at":"2018-09-28 16:16:05",
    "updated_at":"2018-09-28 16:16:05",
    "hello": "hello"
}
```

