<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $guarded = [
        'discipline_id'
    ];

    public function discipline()
    {
        return $this->belongsTo(Disciplines::class);
    }
}
