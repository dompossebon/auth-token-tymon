<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Disciplines extends Model
{
    protected $fillable = [
        'code', 'name', 'description'
    ];
}
