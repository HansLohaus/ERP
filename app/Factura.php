<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';
    protected $fillable = [
        'tipo_entidad_id',
		'servicio_id',
		'folio',
		'tipo_dte',
		'fecha_emision',
		'total_neto',
		'total_exento',
		'total_iva',
		'total_monto_total',
		'estado'

    ];
    //relationship
    public function pagos(){
    	return $this->hasMany('App\Pago','factura_id');
    }
    public function servicio(){
    	return $this->belongsTo('App\Servicio','servicio_id');
    }
    public function tipoentidad(){
    	return $this->belongsTo('App\TipoEntidad','tipo_entidad_id');
    }
    public function cliente(){
        return $this->tipoentidad()->where("tipo", "cliente");
    }   
    public function proveedor(){
        return $this->tipoentidad()->where("tipo", "proveedor");
    }  

}
