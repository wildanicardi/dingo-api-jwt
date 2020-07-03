<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Example extends Model
{
    protected $guarded = [];
    public static $rule = [
        'title' => 'required',
        'description' => 'required',
    ];
}
