<?php

namespace App\gestionAsistencia;

use Illuminate\Database\Eloquent\Model;

class tbl_roles extends Model
{
    protected $connection = 'SistemaEsfot';
    protected $table = 'tbl_roles';
    protected $primaryKey = 'id_rol';
    protected $fillable = ['rol' ];
    public $timestamps=true;

    public function rol(){
        return $this->hasMany('App\User','tipo_rol','id_rol');

    }
}


