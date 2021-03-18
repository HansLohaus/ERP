<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoEntidad extends Model
{
    use SoftDeletes;
    protected $table = 'tipo_entidades';
    protected $fillable = [
        'entidad_id',
		'tipo'
    ];
    //relationship
    public function facturas(){
    	return $this->hasMany('App\Factura','tipo_entidad_id');
    }
    public function servicios(){
    	return $this->hasMany('App\Servicio','tipo_entidad_id');
    }
    public function entidad(){
    	return $this->belongsTo('App\Entidad','entidad_id');
    }

    public static function clientes(){
        return self::with(["entidad"])->where("tipo", "cliente");
    }
    public static function proveedores(){
        return self::with(["entidad"])->where("tipo", "proveedor");
    }
}
