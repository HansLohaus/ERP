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
                        "pago" => $registro[2],
                        "fecha" => $registro[3],
                        "monto" => $registro[4],
                        "descrip_movimiento" => $registro[5],
                        "n_doc" => $registro[6],
                        "sucursal" => $registro[7]
                    ];

                    // Validar 
                    // Log::debug($registro->pago);
                    if ($registro->pago == "c" || $registro->pago == "a") {
                        $fecha=$this->formatearFecha($registro->fecha);
                        if ($fecha !== false) {
                            $pago=Pago::create([
                                "pago" => $registro->pago,
                                "fecha" => $fecha,
                                "monto" => $registro->monto,
                                "descrip_movimiento" => $registro->descrip_movimiento,
                                "n_doc" => $registro->n_doc,
                                "sucursal" => $registro->sucursal
                            ]);
                            if (!empty($registro->folio)) {
                                $facturas_id=explode(',',$registro->folio);
                                $noexiste=[];
                                foreach ($facturas_id as $factura) {
                                    $f=Factura::where("folio", $factura)->exists();
                                    if ($f==false) {
                                        $noexiste[]=$factura;
                                    }
                                }
                                if (count($noexiste) > 0) {
                                    $this->error("facturas no existen ".implode(',',$noexiste));
                                }
                                if (count($facturas_id) > 0) {
                                    $facturas=Factura::whereIn("folio", $facturas_id)->get();
                                    $facturas=$facturas->pluck('id')->toArray();
                                    $pago->facturas()->sync($facturas);
                                }
                            }else{
                                $this->error("folio no existe");
                            }
                            if (!empty($registro->descripcion)) {
                                $boletas_id=explode(',',$registro->descripcion);
                                $noexiste=[];
                                foreach ($boletas_id as $boleta) {
                                    $b=BoletaLiquidacion::where("descripcion", $boleta)->exists();
                                    if ($b==false) {
                                        $noexiste[]=$boleta;
                                    }
                                }
                                if (count($noexiste) > 0) {
                                    $this->error("boletas/liquidaciones no existen ".implode(',',$noexiste));
                                }
                                if (count($boletas_id) > 0) {
                                    $boletas=BoletaLiquidacion::whereIn("descripcion", $boletas_id)->get();
                                    $boletas=$boletas->pluck('id')->toArray();
                                    $pago->boletas()->sync($boletas);
                                }
                            }else{
                                $this->error("descripcion no existe");
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
