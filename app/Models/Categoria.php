<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use SoftDeletes;
    protected $table="categorias";
    protected $fillable = ['categoria'];

    //Trabajar con soft delete
    protected $dates = ['deleted_at'];
}
