<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $table = 'gastos';
    protected $fillable = [
        'trabajador_id',
        'monto',
		'descrip'
    ];

    public function gasto(){
    	return $this->belongsTo('App\Gasto','trabajador_id');
    } 
}
