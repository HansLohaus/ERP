<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class CmdUserPass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:pass {--uid=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza los passwords de los usuarios';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $uid = $this->option("uid");
        if ($uid == null) {
            $usuarios = User::all();
            foreach ($usuarios as $usuario) {
                $pass = bcrypt($usuario->password);
                User::where("id",$usuario->id)->update(["password"=>$pass]);
            }
            echo "Se actualizaron todos los passwords de los usuarios".PHP_EOL;
        } else {
            $usuario = User::find($uid);
            $usuario->password = bcrypt($usuario->password);
            $usuario->save();
            echo "Se actualizo el password del usuario ".$usuario->name." exitosamente";
        }       
    }
}
