<?php

use Illuminate\Database\Seeder;
use App\Entidad;
use App\TipoEntidad;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $tipoentidad = TipoEntidad::insert([
            "tipo" => "proveedor"
        ]);

        $entidad = Entidad::insert([
            "rut" => "97036000K",
            "id_tipo_entidad" => "2",
            "razon_social" => "Santander Chile",
            "nombre_fantasia" => "Banco Santander",
            "nombre_contacto_fin" => "",
            "nombre_contacto_tec" => "",
            "fono_contacto_fin" => "",
            "fono_contacto_tec" => "",
            "email_contacto_fin" => "",
            "email_contacto_tec" => "",
            "activo" => 1
        ]);

        $entidad = Entidad::insert([
            "rut" => "786272106",
            "id_tipo_entidad" => "2",
            "razon_social" => "Hipermercados Tottus S.A.",
            "nombre_fantasia" => "Supermercado Tottus",
            "nombre_contacto_fin" => "",
            "nombre_contacto_tec" => "",
            "fono_contacto_fin" => "",
            "fono_contacto_tec" => "",
            "email_contacto_fin" => "",
            "email_contacto_tec" => "",
            "activo" => 1
        ]);

        $entidad = Entidad::insert([
            "rut" => "967564303",
            "id_tipo_entidad" => "2",
            "razon_social" => "Chilexpress S.A.",
            "nombre_fantasia" => "Chilexpress",
            "nombre_contacto_fin" => "",
            "nombre_contacto_tec" => "",
            "fono_contacto_fin" => "",
            "fono_contacto_tec" => "",
            "email_contacto_fin" => "",
            "email_contacto_tec" => "",
            "activo" => 1
        ]);

        $entidad = Entidad::insert([
            "rut" => "968069802",
            "id_tipo_entidad" => "2",
            "razon_social" => "Entel PCS Telecomunicaciones S.A.",
            "nombre_fantasia" => "Entel",
            "nombre_contacto_fin" => "",
            "nombre_contacto_tec" => "",
            "fono_contacto_fin" => "",
            "fono_contacto_tec" => "",
            "email_contacto_fin" => "",
            "email_contacto_tec" => "",
            "activo" => 1
        ]);

        $entidad = Entidad::insert([
            "rut" => "81201000K",
            "id_tipo_entidad" => "2",
            "razon_social" => "Cencosud Retail",
            "nombre_fantasia" => "Paris",
            "nombre_contacto_fin" => "",
            "nombre_contacto_tec" => "",
            "fono_contacto_fin" => "",
            "fono_contacto_tec" => "",
            "email_contacto_fin" => "",
            "email_contacto_tec" => "",
            "activo" => 1
        ]);

        $entidad = Entidad::insert([
            "rut" => "762268760",
            "id_tipo_entidad" => "2",
            "razon_social" => "Inversiones y servicios solucionesd Limitada",
            "nombre_fantasia" => "SolucionesD",
            "nombre_contacto_fin" => "",
            "nombre_contacto_tec" => "",
            "fono_contacto_fin" => "",
            "fono_contacto_tec" => "",
            "email_contacto_fin" => "",
            "email_contacto_tec" => "",
            "activo" => 1
        ]);

        $entidad = Entidad::insert([
            "rut" => "762773716",
            "id_tipo_entidad" => "2",
            "razon_social" => "Virtual Pyme SPA",
            "nombre_fantasia" => "Virtual Pyme",
            "nombre_contacto_fin" => "",
            "nombre_contacto_tec" => "",
            "fono_contacto_fin" => "",
            "fono_contacto_tec" => "",
            "email_contacto_fin" => "",
            "email_contacto_tec" => "",
            "activo" => 1
        ]);

        $entidad = Entidad::insert([
            "rut" => "765686601",
            "id_tipo_entidad" => "2",
            "razon_social" => "Easy Retail S.A.",
            "nombre_fantasia" => "Easy",
            "nombre_contacto_fin" => "",
            "nombre_contacto_tec" => "",
            "fono_contacto_fin" => "",
            "fono_contacto_tec" => "",
            "email_contacto_fin" => "",
            "email_contacto_tec" => "",
            "activo" => 1
        ]);

        $entidad = Entidad::insert([
            "rut" => "76307949K",
            "id_tipo_entidad" => "2",
            "razon_social" => "Teknologik Chile SpA",
            "nombre_fantasia" => "Teknologik",
            "nombre_contacto_fin" => "",
            "nombre_contacto_tec" => "",
            "fono_contacto_fin" => "",
            "fono_contacto_tec" => "",
            "email_contacto_fin" => "",
            "email_contacto_tec" => "",
            "activo" => 1
        ]);

        $entidad = Entidad::insert([
            "rut" => "761002406",
            "id_tipo_entidad" => "2",
            "razon_social" => "Inversiones San Cristobal SPA",
            "nombre_fantasia" => "Inversiones San Cristobal",
            "nombre_contacto_fin" => "",
            "nombre_contacto_tec" => "",
            "fono_contacto_fin" => "",
            "fono_contacto_tec" => "",
            "email_contacto_fin" => "",
            "email_contacto_tec" => "",
            "activo" => 1
        ]);

    }
}
