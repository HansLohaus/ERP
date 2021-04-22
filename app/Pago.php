<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    protected $fillable = [
        'pago',
        'fecha',
        'monto',
        'descrip_movimiento', 
        'n_doc', 
        'sucursal'
    ];
//relationship
    public function facturas(){
        return $this->belongsToMany('App\Factura','factura_pago');
    }
    public function boletas(){
        return $this->belongsToMany('App\BoletaLiquidacion','boleta_liquidacion_pago');
    }
    public function facturas_pagos(){
        return $this->hasMany('App\Factura_Pago','pago_id');
    }
    public function boletas_liquidaciones_pagos(){
        return $this->hasMany('App\BoletaLiquidacion_Pago','pago_id');
    }
//
    
}
