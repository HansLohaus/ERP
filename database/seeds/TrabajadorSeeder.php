<?php

use Illuminate\Database\Seeder;
use App\Trabajador;

class TrabajadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trabajador = Trabajador::insert([
            "nombres" => "DIEGO ALONSO ALEJANDRO ",
            "apellidoP" => "BERNALDO DE QUIROS",
            "apellidoM" => "RIVERA",
            "rut" => "16.838.153-0",
            "fecha_nac" => "1988-09-07",
            "direccion" => "Álvarez 58 depto. 112, Viña del Mar",
            "cargo" => "",
            "profesion" => "Ingeniero Civil Informático",
            "sueldo" => "",
            "fecha_contrato" => null,
            "fono" => "",
            "email" => "",
            "email_alt" => "",
            "numero_cuenta_banc" => "",
            "titular_cuenta_banc" => "",
            "banco" => "",
            "tipo_cuenta" => "",
            "afp" => "Plan Vital",
            "prevision" => "Nueva Más Vida",
        ]);

        $trabajador = Trabajador::insert([
            "nombres" => "DIEGO IGNACIO ",
            "apellidoP" => "RAMIREZ",
            "apellidoM" => "HENRÍQUEZ",
            "rut" => "20.360.343-6",
            "fecha_nac" => "2000-01-31",
            "direccion" => "Puerto Sídney 450 , Viña del mar",
            "cargo" => "",
            "profesion" => "Técnico Universitario en Informática",
            "sueldo" => "",
            "fecha_contrato" => null,
            "fono" => "",
            "email" => "",
            "email_alt" => "",
            "numero_cuenta_banc" => "",
            "titular_cuenta_banc" => "",
            "banco" => "",
            "tipo_cuenta" => "",
            "afp" => "Plan Vital",
            "prevision" => "Fonasa",
        ]);

        $trabajador = Trabajador::insert([
            "nombres" => "GASTON ANTONIO",
            "apellidoP" => "MARSANO ",
            "apellidoM" => "SOUMASTRE",
            "rut" => "15.993.182-K",
            "fecha_nac" => "1985-02-18",
            "direccion" => "Siete Norte 1256 dpto 1503,  Viña del mar",
            "cargo" => "",
            "profesion" => "Ingeniero en Administración de Empresas",
            "sueldo" => "",
            "fecha_contrato" => null,
            "fono" => "",
            "email" => "",
            "email_alt" => "",
            "numero_cuenta_banc" => "",
            "titular_cuenta_banc" => "",
            "banco" => "",
            "tipo_cuenta" => "",
            "afp" => "Modelo",
            "prevision" => "Cruz Blanca",
        ]);

        $trabajador = Trabajador::insert([
            "nombres" => "FABIAN IGNACIO",
            "apellidoP" => "PULGAR",
            "apellidoM" => "LOPEZ",
            "rut" => "18.563.134-6",
            "fecha_nac" => "1994-01-02",
            "direccion" => "Av. Chile #1119 Villa Argelia, San Felipe",
            "cargo" => "",
            "profesion" => "Técnico Universitario en Informática",
            "sueldo" => "",
            "fecha_contrato" => null,
            "fono" => "",
            "email" => "",
            "email_alt" => "",
            "numero_cuenta_banc" => "",
            "titular_cuenta_banc" => "",
            "banco" => "",
            "tipo_cuenta" => "",
            "afp" => "Plan Vital",
            "prevision" => "Fonasa",
        ]);

        // $trabajador = Trabajador::insert([
        //     "nombres" => "CONSTANZA",
        //     "apellidoP" => "GALVEZ",
        //     "apellidoM" => "PAEZ",
        //     "rut" => "",
        //     "fecha_nac" => "",
        //     "direccion" => "",
        //     "cargo" => "",
        //     "profesion" => "",
        //     "sueldo" => "",
        //     "fecha_contrato" => null,
        //     "fono" => "",
        //     "email" => "",
        //     "email_alt" => "",
        //     "numero_cuenta_banc" => "",
        //     "titular_cuenta_banc" => "",
        //     "banco" => "",
        //     "tipo_cuenta" => "",
        //     "afp" => "",
        //     "prevision" => "",
        // ]);

        // $trabajador = Trabajador::insert([
        //     "nombres" => "JULIA",
        //     "apellidoP" => "SUAREZ",
        //     "apellidoM" => "",
        //     "rut" => "",
        //     "fecha_nac" => "",
        //     "direccion" => "",
        //     "cargo" => "",
        //     "profesion" => "",
        //     "sueldo" => "",
        //     "fecha_contrato" => null,
        //     "fono" => "",
        //     "email" => "",
        //     "email_alt" => "",
        //     "numero_cuenta_banc" => "",
        //     "titular_cuenta_banc" => "",
        //     "banco" => "",
        //     "tipo_cuenta" => "",
        //     "afp" => "",
        //     "prevision" => "",
        // ]);

        $trabajador = Trabajador::insert([
            "nombres" => "MATIAS IGNACIO",
            "apellidoP" => "GAJARDO",
            "apellidoM" => "LARA",
            "rut" => "19.695.123-7",
            "fecha_nac" => "1998-04-29",
            "direccion" => "Divina Providencia 1099, Linares",
            "cargo" => "Desarrollador de software",
            "profesion" => "Ingeniero Informático",
            "sueldo" => "",
            "fecha_contrato" => null,
            "fono" => "931072669",
            "email" => "matias.gajardo.lara98@gmail.com",
            "email_alt" => "matt-695@hotmail.com",
            "numero_cuenta_banc" => "",
            "titular_cuenta_banc" => "",
            "banco" => "",
            "tipo_cuenta" => "",
            "afp" => "",
            "prevision" => "Dipreca",
        ]);
    }
}
