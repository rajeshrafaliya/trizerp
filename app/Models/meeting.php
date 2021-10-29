<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class meeting extends Model
{
    use SoftDeletes;

    protected $table = "meeting"; 
    public $timestamps = false;  
    protected $hidden = ["deleted_at"]; 
}
