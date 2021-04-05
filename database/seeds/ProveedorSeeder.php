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
        $entidad = Entidad::insert([
            "rut" => "97036000-K",
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
            "rut" => "78627210-6",
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
            "rut" => "96756430-3",
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
            "rut" => "96806980-2",
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
            "rut" => "81201000-K",
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
            "rut" => "76226876-0",
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
            "rut" => "76277371-6",
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
            "rut" => "76568660-1",
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
            "rut" => "76307949-K",
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
            "rut" => "76100240-6",
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

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "13",
            "tipo" => "proveedor"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "14",
            "tipo" => "proveedor"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "15",
            "tipo" => "proveedor"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "16",
            "tipo" => "proveedor"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "17",
            "tipo" => "proveedor"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "18",
            "tipo" => "proveedor"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "19",
            "tipo" => "proveedor"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "20",
            "tipo" => "proveedor"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "21",
            "tipo" => "proveedor"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "22",
            "tipo" => "proveedor"
        ]);
    }
}