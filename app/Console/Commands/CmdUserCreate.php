<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class CmdUserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {user} {password} {--name=} {--rol=normal} {--email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un nuevo usuario';

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
        $username = $this->argument("user");
        $password = $this->argument("password");

        $name = $this->option("name");
        if ($name == null) $name = $username;

        $rol = $this->option("rol");
        $email = $this->option("email");

        User::create([
            "username" => $username,
            "name" => $name,
            "password" => bcrypt($password),
            "rol" => $rol,
            "email" => $email
        ]);
        echo "El usuario fue creado exitosamente";
    }
}
