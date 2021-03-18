<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEntidad extends Model
{
    protected $table = 'clientes';
    protected $fillable = [
        'entidad_id',
		'tipo'
    ];
    //relationship
    public function facturas(){
    	return $this->hasMany('App\Factura','tipo_entidades_id');
    }
    public function servicios(){
    	return $this->hasMany('App\Servicio','tipo_entidades_id');
    }
    public function entidad(){
    	return $this->belongsTo('App\Entidad','entidades_id');
    }
}
