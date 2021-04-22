<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoletaLiquidacionPago extends Model
{
    protected $table = 'boleta_liquidacion_pago';
    protected $fillable = [
        'boleta_liquidacion_id',
        'pago_id',
		'comentario'
    ];
    public function boletaliquidacion(){
    	return $this->belongsTo('App\BoletaLiquidacion','boleta_liquidacion_id');
    }
    public function pago(){
    	return $this->belongsTo('App\Pago','pago_id');
    }
}
