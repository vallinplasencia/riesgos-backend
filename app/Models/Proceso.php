<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proceso extends Model
{
    use SoftDeletes;
    protected $table = "procesos";
    protected $fillable = ['proceso'];

    //Soft delete
    protected $dates = ['deleted_at'];
}
