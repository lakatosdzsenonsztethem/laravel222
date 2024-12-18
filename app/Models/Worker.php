<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    


    public function department(){
        return $this->belongsTo(Department::class);
    }
}


