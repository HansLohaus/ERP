<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
	protected $table = 'entidades';
	protected $fillable = [
		'rut',
		'id_tipo_entidad',
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

	public function gastos()
	{
		return $this->morphOne('App\Gasto', 'gastable');
	}
	public function tipo_entidad()
	{
		return $this->belongsTo('App\TipoEntidad','id_tipo_entidad');
	}
	public function cliente()
	{
		return $this->tipo_entidad()->where("tipo", "cliente");
	}
	public function proveedor()
	{
		return $this->tipo_entidad()->where("tipo", "proveedor");
	}
}
