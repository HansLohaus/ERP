<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
  protected $table = "logs";
	public $timestamps = false;

	protected $fillable = [
		'fecha',
		'accion',
		'user_id',
		'ip'
	];

	/**
	* Formatear el valor de la fecha
	*/
	public function getFechaAttribute($value) {
		return date_format(date_create($value),"d-m-Y H:i:s");
	}

	// Se obtiene el usuario de la accion
	public function usuario() {
		return $this->belongsTo("App\User","user_id");
	}
}
