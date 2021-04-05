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
use App\Pago;
use App\BoletaLiquidacion;
use Exception;
use File;
use Log;
use DB;
class JobCargaPagos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $filename;
    protected $separador = ";";
    protected $log;

    public function __construct($filename)
    {
        $this->filename = $filename;
        $this->log = new Logger('carga-pagos');
        $this->log->pushHandler(
            new StreamHandler(storage_path('logs/carga-pagos.log')),
            Logger::INFO
        );
    }
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

    public function formatearFecha($fecha){
        $f=date_create_from_format('Y-m-d',$fecha);
        if ($f ==false) {
            $f=date_create_from_format('d-m-Y',$fecha);
            if ($f ==false) {
                $f=date_create_from_format('Y/m/d',$fecha);
                if ($f ==false) {
                    $f=date_create_from_format('d/m/Y',$fecha);
                }
            }
        }
        if ($f !== false) {
            return date_format($f, 'Y-m-d');
        }else{
            return false;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            
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

            while ($registro = fgets($csv)) {

                // Se obtiene el registro y se guarda en un arreglo
                $registro = str_getcsv($registro, $this->separador);
                if ($registro !== "") {

                    // Se kimpian los datos
                    foreach ($registro as $key => $value) {
                        $registro[$key] = trim(mb_strtolower($value));   
                    }

                    // Se obtiene el registro como colección
                    $registro = (object) [
                        
                        // Agregar campos asociados a la factura
                        "folio" => $registro[0],
                        "descripcion" => $registro[1],
                        "ine" => $registro[2],
                        "fecha_pago" => $registro[3],
                        "monto" => $registro[4],
                        "monto_total_transf" => $registro[5],
                        "descrip_movimiento" => $registro[6]
                    ];

                    // Validar 
                    if ($registro->ine == "ingreso" || $registro->ine == "egreso") {
                        $fecha=$this->formatearFecha($registro->fecha_pago);
                        if ($fecha !== false) {
                            if (!empty($registro->folio)) {
                                $factura=Factura::where("folio", $registro->folio)->first();
                                if ($factura !== null) {
                                    $boletaliquidacion=BoletaLiquidacion::where("descripcion", $registro->descripcion)->first();
                                    if ($boletaliquidacion !== null) {
                                        $existe=Pago::where([
                                            "factura_id" => $factura->id,
                                            "boleta_liquidacion_id" => $boletaliquidacion->id,
                                            "ine" => $registro->ine,
                                        ])->exists();
                                        if ($existe==false) {
                                            Pago::create([
                                                "factura_id" => $factura->id,
                                                "boleta_liquidacion_id" => $boletaliquidacion->id,
                                                "ine" => $registro->ine,
                                                "fecha_pago" => $fecha,
                                                "monto" => $registro->monto,
                                                "monto_total_transf" => $registro->monto_total_transf,
                                                "descrip_movimiento" => $registro->descrip_movimiento,
                                            ]);
                                        }else{
                                            $this->error("la pago ya esta en la bd");
                                        }
                                    }else{
                                        $this->error("la boleta/liquidacion no existe");
                                    }
                                }else{
                                    $this->error("la factura no existe");
                                }
                            }else{
                                $this->error("folio no posee formato adecuado");
                            }
                        }else{
                            $this->error("fecha pago invalida");
                        }
                    }else{
                        $this->error("tipo invalido");
                    }
                }
            }









             if (File::exists($this->filename)) {
                File::delete($this->filename);
            }


        } catch (Exception $e) {
            $this->handleError($e);
        }
    }
}
