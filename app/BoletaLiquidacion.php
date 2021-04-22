<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoletaLiquidacion extends Model
{
    protected $table = 'boletas_liquidaciones';
    protected $fillable = [
        'trabajador_id',
        'descripcion',
		'monto_total',
		'monto_liquido',
		'boleta_liq',
		'sueldo_base',
		'gratificaciones',
		'dias_trabajados',
		'desc_isapre',
		'desc_afp',
		'desc_seguro_cesantia',
		'impuesto_unico'
    ];
    public function pagos(){
        return $this->belongsToMany('App\Pago','boleta_liquidacion_pago');
    }
    public function boletas_liquidaciones_pagos(){
    	return $this->hasMany('App\BoletaLiquidacion_Pago','boleta_liquidacion_id');
    }

    public function trabajador(){
    	return $this->belongsTo('App\Trabajador','trabajador_id');
    }
}
