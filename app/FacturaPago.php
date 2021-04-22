<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaPago extends Model
{
    protected $table = 'factura_pago';
    protected $fillable = [
        'factura_id',
        'pago_id',
		'comentario'
    ];
    public function factura(){
    	return $this->belongsTo('App\Factura','factura_id');
    }
    public function pago(){
    	return $this->belongsTo('App\Pago','pago_id');
    }
}
