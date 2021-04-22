<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use \Illuminate\Support\Str;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

use App\Factura;
use App\TipoEntidad;
use App\Entidad;
use App\Servicio;
use Exception;
use File;
use Log;
use Rut;
use DB;

class JobCargaFacturas implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Ruta en donde se encuentra el archivo
     *
     * @var string
     */
    protected $filename;

    protected $separador = ";";
    protected $log;

    /**
     * Create a new job instance.
     *  
     * @param string $filename ruta del archivo
     * @return void
     */
    public function __construct($filename)
    {
        $this->filename = $filename;

        // Se crea log principal
        $this->log = new Logger('carga-facturas');
        $this->log->pushHandler(
            new StreamHandler(storage_path('logs/carga-facturas.log')),
            Logger::INFO
        );
    }

    /**
     * Guarda el error en un log segun el caso
     * 
     * @param  Exception $exception 
     * @return void
     */
    public function logError(Exception $exception) {
        Log::error($exception);
        if ($this->log !== null)
            $this->log->error($exception);
        else
            Log::error($exception);
    }

    public function error($mensaje) {
        $this->log->error($mensaje);
    }

    /**
     * Función que se ejecuta cuando el proceso falla
     * 
     * @return void
     */
    public function handleError(Exception $e) {

        // Se borra el archivo asociado
        if (File::exists($this->filename)) {
            File::delete($this->filename);
        }

        // Se ignora transacción
        DB::rollback();

        // Se guarda el log
        $this->logError($e);
    }

    public function formatearFechaE($fechaE){
        $f=date_create_from_format('Y-m-d',$fechaE);
        if ($f ==false) {
            $f=date_create_from_format('d-m-Y',$fechaE);
            if ($f ==false) {
                $f=date_create_from_format('Y/m/d',$fechaE);
                if ($f ==false) {
                    $f=date_create_from_format('d/m/Y',$fechaE);
                }
            }
        }
        if ($f !== false) {
            return date_format($f, 'Y-m-d');
        }else{
            return false;
        }
    }

    public function formatearFechaR($fechaR){
        $f=date_create_from_format('Y-m-d',$fechaR);
        if ($f ==false) {
            $f=date_create_from_format('d-m-Y',$fechaR);
            if ($f ==false) {
                $f=date_create_from_format('Y/m/d',$fechaR);
                if ($f ==false) {
                    $f=date_create_from_format('d/m/Y',$fechaR);
                }
            }
        }
        if ($f !== false) {
            return date_format($f, 'Y-m-d');
        }else{
            return false;
        }
    }

    public function validarRut($rut){
        try {
            $parsed = Rut::parse(trim($rut));
            return $parsed->validate(); 
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
    }

    public function reedCommon($registro){
        $registro[1]=preg_replace('/[^\dkK]/i','', $registro[1]);
        $columnas=count($registro);
        if ($columnas==15){
            return $this->reedCliente($registro);
        }elseif ($columnas==13) {
            return $this->reedProveedor($registro);
        }else{
            $this->error('el archivo no posee formato adecuado');
            throw new Exception("el archivo no posee formato adecuado", 1);
        }
    }
    public function reedCliente($registro){
        $monto_neto=intval($registro[6]);
        $monto_exento=intval($registro[7]);

        $tipoDTE=0;
        if ($monto_neto > 0) {
            $tipoDTE=33;
        }elseif ($monto_exento > 0) {
            $tipoDTE=34;
        }

        return (object) [
        // Agregar campos asociados a la factura
            "rut_entidad" => $registro[1],
            "tipo_entidad" => "cliente",
            "nombre_servicio" => $registro[2],
            "folio" => $registro[3],
            "tipo_dte" => $tipoDTE,
            "fecha_emision" => $registro[4],
            "total_reparto" => $registro[5],
            "total_neto" => $registro[6],
            "total_exento" => $registro[7],
            "total_iva" => $registro[8],
            "total_monto_total" => $registro[9],
            "fecha_recep" => $registro[10],
            "evento_recep" => $registro[11],
            "cod_otro" => $registro[12],
            "valor_otro" => $registro[13],
            "tasa_otro" => $registro[14],
            "estado" => 'impago'
        ];
    }
    public function reedProveedor($registro){
        $monto_neto=intval($registro[6]);
        $monto_exento=intval($registro[7]);
        
        $tipoDTE=0;
        if ($monto_neto > 0) {
            $tipoDTE=33;
        }elseif ($monto_exento > 0) {
            $tipoDTE=34;
        }

        return (object) [
        // Agregar campos asociados a la factura
            "rut_entidad" => $registro[1],
            "tipo_entidad" => "proveedor",
            "nombre_servicio" => null,
            "folio" => $registro[2],
            "tipo_dte" => $tipoDTE,
            "fecha_emision" => $registro[3],
            "total_reparto" => null,
            "total_neto" => $registro[4],
            "total_exento" => $registro[5],
            "total_iva" => $registro[6],
            "total_monto_total" => $registro[7],
            "fecha_recep" => $registro[8],
            "evento_recep" => $registro[9],
            "cod_otro" => $registro[10],
            "valor_otro" => $registro[11],
            "tasa_otro" => $registro[12],
            "estado" => 'impago'
        ];
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Try/Catch General
        try {

            // Se abre el archivo asociado
            $csv = fopen($this->filename,"r");

            // Se abre el archivo para saber el total de registros
            $file_aux = new \SplFileObject($this->filename, 'r');
            $file_aux->seek(PHP_INT_MAX);
            $total = $file_aux->key()-1;
            unset($file_aux);

            // cabeceras
            if ($registro = fgets($csv)) {
                $registro = str_getcsv($registro, $this->separador);
            } else {
                throw new Exception("Archivo vacío", 1);
            }

            // Se recorre el archivo csv
            while ($registro = fgets($csv)) {

                // Se obtiene el registro y se guarda en un arreglo
                $registro = str_getcsv($registro, $this->separador);
                if ($registro !== "") {

                    // Se kimpian los datos
                    foreach ($registro as $key => $value) {
                        $registro[$key] = trim(mb_strtolower($value));   
                    }

                    // Se obtiene el registro como colección
                    $registro = $this->reedCommon($registro);
                    // Validar tipo entidad antes de hacer esto

                    // $this->log->debug(json_encode($registro));
                    if ($this->validarRut($registro->rut_entidad)) {
                        $entidad = TipoEntidad::with(["entidad"])->where("tipo",$registro->tipo_entidad)
                        ->whereHas("entidad",function($entidad) use ($registro){
                            $entidad->where("rut",$registro->rut_entidad);
                        })->first();
                            if ($entidad == null) {
                            $entidad=Entidad::create([
                                "rut"=> $registro->rut_entidad,
                                "razon_social"=> $registro->nombre_servicio,
                                "nombre_fantasia"=> str_limit($registro->nombre_servicio, $limit = 20)

                            ]);
                            $tipo_entidad=TipoEntidad::create([
                                "entidad_id"=> $entidad->id,
                                "tipo"=> $registro->tipo_entidad
                            ]);
                        }
                            if ($registro->nombre_servicio) {
                                $servicio = Servicio::where("nombre",$registro->nombre_servicio)->first();
                            }else{
                                $servicio=null;
                            }
                            $fechaE=$this->formatearFechaE($registro->fecha_emision);
                            $fechaR=$this->formatearFechaR($registro->fecha_recep);
                            if ($fechaE !== false) {
                                if ($fechaR !== false) {
                                $existe=Factura::where([
                                    "tipo_entidad_id" => $entidad->id,
                                    "folio" => $registro->folio,
                                ])->exists();
                                    if ($existe==false) {
                                        Factura::create([
                                            "tipo_entidad_id" => $entidad->id,
                                            "servicio_id" => $servicio ? $servicio->id : null,
                                            "folio" => $registro->folio,
                                            "tipo_dte" => $registro->tipo_dte,
                                            "fecha_emision" => $fechaE,
                                            "total_reparto" => $registro ? $registro->total_reparto : null,
                                            "total_neto" => $registro->total_neto,
                                            "total_exento" => $registro->total_exento,
                                            "total_iva" => $registro->total_iva,
                                            "total_monto_total" => $registro->total_monto_total,
                                            "fecha_recep" => $fechaR,
                                            "cod_otro" => $registro->cod_otro,
                                            "valor_otro" => $registro->valor_otro,
                                            "tasa_otro" => $registro->tasa_otro,
                                            "estado" => $registro->estado,
                                        ]);
                                    }else{
                                        $this->error("la factura ya esta en la bd");
                                    }
                                }else{
                                $this->error("fecha emision invalida");
                                }
                            }else{
                                $this->error("fecha recepcion invalida");
                            }
                            // Ingresar los datos a la tabla facturas
                        
                    }else{
                        $this->error("rut invalido");
                    }
                }
            }

            // Se borra el archivo asociado
            if (File::exists($this->filename)) {
                File::delete($this->filename);
            }
        }
        catch (Exception $e) {
            $this->handleError($e);
        }
    }
}
