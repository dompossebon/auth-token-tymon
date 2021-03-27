<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AssembledClass extends Model
{
    protected $hidden = ["created_at", "updated_at"];

    public function student()
    {
        return $this->belongsTo(Students::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classes::class,'class_id');
    }

}
