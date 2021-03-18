<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Se crea usuario superadmin
        $user = User::create([
        	"username" => "neering",
			"name" => "Neering",
			"email" => "noresponder@neering.cl",
			"password" => bcrypt("neeringteam"),
			"estado" => 1
        ]);
        $user->assignRole('superadmin');
    }
}
