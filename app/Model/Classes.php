<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $hidden = ["created_at", "updated_at"];

    public function discipline()
    {
        return $this->belongsTo(Disciplines::class);
    }
}
