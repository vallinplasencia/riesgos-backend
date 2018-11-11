<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Responsable extends Model
{
    use SoftDeletes;
    protected $table="responsables";
    protected $fillable = ['nombre', 'funcion', 'area', 'direccion', 'email', 'fechaAlta', 'fechaBaja'];

    //Trabajar con soft delete
    protected $dates = ['deleted_at'];
}
