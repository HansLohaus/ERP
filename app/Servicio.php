<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';
    protected $fillable = [
        'cliente_id',
		'nombre',
		'fecha_inicio',
		'fecha_fin',
		'tipo',
		'estado',
		'numero_propuesta',
		'condicion_pago'
    ];
    //relationship
    public function facturas(){
    	return $this->hasMany('App\Factura','servicio_id');
    }
    public function tipoentidad(){
    	return $this->belongsTo('App\TipoEntidad','tipo_entidad_id');
    }
    
}
