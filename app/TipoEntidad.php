<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoEntidad extends Model
{
    use SoftDeletes;
    protected $table = 'tipo_entidades';
    protected $fillable = [
		'tipo'
    ];
    //relationship
    public function servicios(){
    	return $this->hasMany('App\Servicio','tipo_entidad_id');
    }
    public function entidad(){
    	return $this->belongsTo('App\Entidad','entidad_id');
    }
}
