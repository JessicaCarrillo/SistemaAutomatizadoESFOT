<?php

namespace App\gestionProyector;

use Illuminate\Database\Eloquent\Model;

class tbl_proyector extends Model
{
    protected $connection = 'SistemaEsfot';
    protected $table = 'tbl_proyector';
    protected $primaryKey = 'id_proyector';
    protected $fillable = ['proyector', 'descripcion', 'estado' ];
    public $timestamps=true;

    public function reserva(){
        return $this->hasMany('App\gestionProyector\tbl_ficha_proyector','id_proyector_fk','id_proyector');
    }
}
