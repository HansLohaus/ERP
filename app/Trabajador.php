<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajadores';
    protected $fillable = [
        'nombres',
		'apellidoP',
		'apellidoM',
		'rut',
		'fecha_nac',
		'direccion',
		'cargo',
		'profesion',
		'sueldo',
		'fecha_contrato',
		'fono',
		'email',
		'email_alt',
		'numero_cuenta_banc',
		'titular_cuenta_banc',
		'banco',
		'tipo_cuenta',
		'afp',
		'prevision'
    ];
    public function boletasliquidaciones(){
    	return $this->hasMany('App\BoletaLiquidacion','trabajador_id');
    }
    public function pagos(){
    	return $this->hasMany('App\Pago','trabajador_id');
    }
}
