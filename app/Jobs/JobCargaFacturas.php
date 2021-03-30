<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

use App\Factura;
use App\TipoEntidad;
use App\Servicio;

use Exception;
use File;
use Log;
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

                    // Se obtiene el registro como colección
                    $registro = (object) [
                        
                        // Agregar campos asociados a la factura
                        "rut_entidad" => $registro[0],
                        "tipo_entidad" => $registro[1],
                        "nombre_servicio" => $registro[2],
                        // ...
                    ];

                    // Validar los campos del registro

                    // Validar tipo entidad antes de hacer esto
                    if ($this->tipoEntidadValida($registro)) {
                        $entidad = TipoEntidad::with(["entidad"])->where("tipo",$registro->tipo_entidad)
                        ->whereHas("entidad",function($entidad) use ($registro){
                            $entidad->where("rut",$registro->rut_entidad);
                        })->first();
                        if ($entidad !== null) {
    
                            $servicio = Servicio::where("nombre",$registro->nombre_servicio)->first();
                            if ($servicio !== null) {
                                
                                // Ingresar los datos a la tabla facturas
                                Factura::create([
                                    "tipo_entidad_id" => $entidad->id,
                                    "servicio_id" => $servicio->id,
                                    // ...
                                ]);
                            }
                        }
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

    /**
     * Valida el tipo de entidad
     *
     * @param object $registro
     * @return void
     */
    public function tipoEntidadValida(&$registro) {

    }
}
