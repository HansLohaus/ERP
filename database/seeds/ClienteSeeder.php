<?php

use Illuminate\Database\Seeder;
use App\Entidad;
use App\TipoEntidad;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entidad = Entidad::insert([
            "rut" => "76252588-7",
            "razon_social" => "SERVICIOS INTEGRALES DE COBRANZA Y RECUPERACION DE CAPITALES SPA",
            "nombre_fantasia" => "FULLCOB",
            "nombre_contacto_fin" => "Patricio Rojas",
            "nombre_contacto_tec" => "Patricio Rojas",
            "fono_contacto_fin" => "56938887500",
            "fono_contacto_tec" => "56938887500",
            "email_contacto_fin" => "patricio.rojas@call-fullcob.cl",
            "email_contacto_tec" => "patricio.rojas@call-fullcob.cl",
            "activo" => 1
        ]);

        $entidad = Entidad::insert([
            "rut" => "76780080-0",
            "razon_social" => "SERVICIOS INTEGRALES MARCOS GALLEGUILLOS DELGADO SPA",
            "nombre_fantasia" => "PRADERAS VERDES",
            "nombre_contacto_fin" => "Monica Vargas",
            "nombre_contacto_tec" => "Hugo Vega",
            "fono_contacto_fin" => "56323207695",
            "fono_contacto_tec" => "56979963250",
            "email_contacto_fin" => "monica.vargas@praderasverdes.cl",
            "email_contacto_tec" => "hugo.vega@praderasverdes.cl ",
            "activo" => 1
        ]);

        $entidad = Entidad::insert([
            "rut" => "7490679-6",
            "razon_social" => "RENE ALBERTO GUAMAN ALVAREZ",
            "nombre_fantasia" => "RG",
            "nombre_contacto_fin" => "Veronica Contreras",
            "nombre_contacto_tec" => "",
            "fono_contacto_fin" => "56953322465",
            "fono_contacto_tec" => "",
            "email_contacto_fin" => "vcontreras@rg-electricidad.cl",
            "email_contacto_tec" => "",
            "activo" => 1
        ]);

        $entidad = Entidad::insert([
            "rut" => "76114726-9",
            "razon_social" => "MULTICOB CHILE SPA",
            "nombre_fantasia" => "MULTICOB",
            "nombre_contacto_fin" => "Mirtha Canaan",
            "nombre_contacto_tec" => "Jalima Contreras",
            "fono_contacto_fin" => "56964380755",
            "fono_contacto_tec" => "56942209157",
            "email_contacto_fin" => "m.canaan@multicob.cl",
            "email_contacto_tec" => "jcontreras@multicob.cl",
            "activo" => 1
        ]);

        $entidad = Entidad::insert([
            "rut" => "96884180-7",
            "razon_social" => "SERVICIOS INTEGRALES DE MANTENIMIENTOS TECNICOS SOCIEDAD ANONIMA",
            "nombre_fantasia" => "SIMANTEC",
            "nombre_contacto_fin" => "Moises Araya",
            "nombre_contacto_tec" => "Alvaro Olguin",
            "fono_contacto_fin" => "56998214362",
            "fono_contacto_tec" => "56982880822",
            "email_contacto_fin" => "maraya@simantec.cl",
            "email_contacto_tec" => "aolguin@simantec.cl",
            "activo" => 0
        ]);

        $entidad = Entidad::insert([
            "rut" => "77559020-3",
            "razon_social" => "COBRANZAS Y CALL CENTER LIMITADA",
            "nombre_fantasia" => "COBYCALL",
            "nombre_contacto_fin" => "Yasna Cruz",
            "nombre_contacto_tec" => "",
            "fono_contacto_fin" => "998882192",
            "fono_contacto_tec" => "",
            "email_contacto_fin" => "ycruz@cobycallcenter.cl",
            "email_contacto_tec" => "",
            "activo" => 1
        ]);

        $entidad = Entidad::insert([
            "rut" => "94272000-9",
            "razon_social" => "AES GENER S A",
            "nombre_fantasia" => "AES GENER",
            "nombre_contacto_fin" => "Ma. Constanza Muñoz",
            "nombre_contacto_tec" => "Sergio Guzman",
            "fono_contacto_fin" => "56968754060",
            "fono_contacto_tec" => "56981374700",
            "email_contacto_fin" => "asim.mmunoz.c@aes.com",
            "email_contacto_tec" => "sergio.guzman@aes.com",
            "activo" => 1
        ]);

        $entidad = Entidad::insert([
            "rut" => "76224056-4",
            "razon_social" => "SOCIEDAD DE TELECOMUNICACIONES Y SERVICIOS SPA",
            "nombre_fantasia" => "VOZDGITAL",
            "nombre_contacto_fin" => "Paz Latorre",
            "nombre_contacto_tec" => "Rodrigo Romero",
            "fono_contacto_fin" => "",
            "fono_contacto_tec" => "56987740184",
            "email_contacto_fin" => "administracion@vozdigital.cl, paz.latorre@vozdigital.net",
            "email_contacto_tec" => "rodrigo.romero@vozdigital.net",
            "activo" => 1
        ]);

        $entidad = Entidad::insert([
            "rut" => "78494600-2",
            "razon_social" => "SOC COMERCIAL LA CABANA LIMITADA",
            "nombre_fantasia" => "PEUMAYEN",
            "nombre_contacto_fin" => "Erica Carevic",
            "nombre_contacto_tec" => "",
            "fono_contacto_fin" => "940734962",
            "fono_contacto_tec" => "",
            "email_contacto_fin" => "",
            "email_contacto_tec" => "erica@peumayen.cl",
            "activo" => 0
        ]);

        $entidad = Entidad::insert([
            "rut" => "76093809-2",
            "razon_social" => "DIGITEX CHILE S.A.",
            "nombre_fantasia" => "DIGITEX",
            "nombre_contacto_fin" => "Pamela Abaca",
            "nombre_contacto_tec" => "",
            "fono_contacto_fin" => "56963340355",
            "fono_contacto_tec" => "",
            "email_contacto_fin" => "pamela.abaca@comdatagroup.com",
            "email_contacto_tec" => "",
            "activo" => 0
        ]);

        $entidad = Entidad::insert([
            "rut" => "96813520-1",
            "razon_social" => "CHILQUINTA ENERGIA S A",
            "nombre_fantasia" => "CHILQUNTA",
            "nombre_contacto_fin" => "",
            "nombre_contacto_tec" => "Danny Valencia",
            "fono_contacto_fin" => "",
            "fono_contacto_tec" => "",
            "email_contacto_fin" => "",
            "email_contacto_tec" => "dvalenci@chilquinta.cl",
            "activo" => 1
        ]);

        $entidad = Entidad::insert([
            "rut" => "76000769-2",
            "razon_social" => "SOCIEDAD DE INVERSIONES Y SERVICIOS DUCAL LIMITADA",
            "nombre_fantasia" => "EQUIFAX",
            "nombre_contacto_fin" => "Krassna Fuentes",
            "nombre_contacto_tec" => "Rodrigo Calderon",
            "fono_contacto_fin" => "",
            "fono_contacto_tec" => "",
            "email_contacto_fin" => "krassna.fuentes@equifax.cl",
            "email_contacto_tec" => "rodrigo.calderon@agencias.equifax.cl",
            "activo" => 0
        ]);


        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "1",
            "tipo" => "cliente"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "2",
            "tipo" => "cliente"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "3",
            "tipo" => "cliente"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "4",
            "tipo" => "cliente"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "5",
            "tipo" => "cliente"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "6",
            "tipo" => "cliente"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "7",
            "tipo" => "cliente"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "8",
            "tipo" => "cliente"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "9",
            "tipo" => "cliente"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "10",
            "tipo" => "cliente"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "11",
            "tipo" => "cliente"
        ]);

        $tipoentidad = TipoEntidad::insert([
            "entidad_id" => "12",
            "tipo" => "cliente"
        ]);


    }
}


































