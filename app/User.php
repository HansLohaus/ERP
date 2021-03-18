<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use App\Logs;
use Request;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    use HasRoles;
    protected $table = 'users';
    protected $dates = ['deleted_at'];
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 
        'name', 
        'password',
        'email',
        'estado'
    ];
    protected $appends = [
        'estado_f',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Crea un registro en la tabla logs
     * @param  string $accion : mensaje de accion
     */
    public function log($accion) {
        return Logs::create([
            "fecha" => date("Y-m-d H:i:s"),
            "accion" => $accion,
            "user_id" => $this->id,
            "ip" => Request::ip()
        ]);
    }

    /**
     * Para customizar email para resetear contraseña
     * @param  string $token
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPassword($token));
    }

    // Logs asociados al usuario
    public function logs() {
        return $this->hasMany("App\Logs","user_id")->orderBy("fecha","desc");
    }

    // Para saber la verificacion del usuario
    public function verifyUser() {
        return $this->hasOne('App\VerifyUser');
    }

    //-------------------------------------------------------------------------------
    // Atributos adicionales
    //-------------------------------------------------------------------------------
    
    // Estado formateado
    public function getEstadoFAttribute() {
        if (isset($this->attributes["estado"])) {
            switch ($this->attributes["estado"]) {
                case 0:
                    return "Eliminado";
                    break;
                case 1:
                    return "Activo";
                    break;
                case 2:
                    return "Inactivo";
                    break;
                default:
                    return "Activo";
            }
        } else{
            return "Activo";
        }
    }

    // Rol
    public function getRoleAttribute() {
        return ucfirst($this->roles[0]->name);
    }
}
