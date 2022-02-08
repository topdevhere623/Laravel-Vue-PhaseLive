<?php

namespace App;

use Nicolaslopezj\Searchable\SearchableTrait;

class Permission extends \Spatie\Permission\Models\Permission
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'permissions.name' => 20
        ]
    ];
}
