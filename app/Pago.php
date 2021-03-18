<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    protected $fillable = [
        'factura_id',
        'fecha_pago', 
        'monto', 
        'monto_total_transf',
        'descrip_movimiento'
    ];
//relationship
    public function factura(){
    	return $this->belongsTo('App\Factura','factura_id');
    }




//
    
}
