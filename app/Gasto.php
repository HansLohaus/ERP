<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $table = 'gastos';
    protected $fillable = [
        'monto',
		'descrip',
        'path',
        'reembolso',
        'fecha_gasto'
    ];

    public function gastable(){
        return $this->morphTo();
    }

}
