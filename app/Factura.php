<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';
    protected $fillable = [
        'entidad_id',
		'servicio_id',
		'folio',
		'tipo_dte',
		'fecha_emision',
        'total_reparto',
		'total_neto',
		'total_exento',
		'total_iva',
		'total_monto_total',
        'fecha_recep',
        'evento_recep',
        'cod_otro',
        'valor_otro',
        'tasa_otro',
		'estado'

    ];
    //relationship
    public function pagos(){
        return $this->belongsToMany('App\Pago','factura_pago');
    }
    public function facturas_pagos(){
    	return $this->hasMany('App\FacturaPago','factura_id');
    }
    public function servicio(){
    	return $this->belongsTo('App\Servicio','servicio_id');
    }
    public function entidad(){
    	return $this->belongsTo('App\Entidad','entidad_id');
    }

    public function cliente(){
        return $this->entidad()->where("id_tipo_entidad", "1");
    }   
    public function proveedor(){
        return $this->entidad()->where("id_tipo_entidad", "2");
    }  
}
