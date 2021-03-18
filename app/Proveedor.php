<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $fillable = [
        'rut',
		'razon_social',
		'nombre_fantasia',
		'nombre_contacto_fin',
		'nombre_contacto_tec',
		'fono_contacto_fin',
		'fono_contacto_tec',
		'email_contacto_fin',
		'email_contacto_tec',
		'activo'
    ];
    //relationship
    public function facturas(){
    	return $this->hasMany('App\Factura','tipo_entidad_id');
    }
    public function servicios(){
    	return $this->hasMany('App\Servicio','tipo_entidad_id');
    }
}
