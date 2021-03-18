<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
     protected $table = 'entidades';
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
    public function tipoentidades(){
    	return $this->hasMany('App\TipoEntidad','entidades_id');
    }
}
