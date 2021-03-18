<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyUser extends Model
{
	protected $table = "verify_users";
	protected $guarded = [];
	protected $primaryKey = 'user_id';
	protected $fillable = [
        'user_id', 
        'token'
    ];

	// Usuario asociado a la verificación
    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
