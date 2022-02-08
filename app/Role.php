<?php

namespace App;

use Nicolaslopezj\Searchable\SearchableTrait;

class Role extends \Spatie\Permission\Models\Role
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'roles.name' => 20,
        ],
    ];
}
