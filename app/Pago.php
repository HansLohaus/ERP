<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    protected $fillable = [
        'factura_id',
        'boleta_liquidacion_id',
        'ine',
        'fecha_pago', 
        'monto', 
        'monto_total_transf',
        'descrip_movimiento'
    ];
//relationship
    public function boletaliquidacion(){
        return $this->belongsTo('App\BoletaLiquidacion','boleta_liquidacion_id');
    }
    public function factura(){
    	return $this->belongsTo('App\Factura','factura_id');
    }
//
    
}
