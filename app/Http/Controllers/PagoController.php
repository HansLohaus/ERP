<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pago;
use App\Factura;
use App\BoletaLiquidacion;
use Auth;
use File;
use App\Jobs\JobCargaPagos;
use App\FacturaPago;
class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->has('totales')){
                $pagos=Pago::count();
                $pagos_ingresos=Pago::where('pago','A')->count();
                $pagos_egresos=Pago::where('pago','C')->count();
                $sum_ingresos=Pago::where('pago','A')->sum('monto');
                $sum_egresos=Pago::where('pago','C')->sum('monto');
                $utilidades=$sum_ingresos-$sum_egresos;
                $format_ingresos=number_format($sum_ingresos);
                $format_egresos=number_format($sum_egresos);
                $format_utilidades=number_format($utilidades);
            return response()->json([
                'pagos'=>$pagos,
                'pagos_ingresos'=>$pagos_ingresos,
                'pagos_egresos'=>$pagos_egresos,
                'sum_ingresos'=>$sum_ingresos,
                'sum_egresos'=>$sum_egresos,
                'utilidades'=>$utilidades,
                'format_ingresos'=>$format_ingresos,
                'format_egresos'=>$format_egresos,
                'format_utilidades'=>$format_utilidades
            ]);

        }elseif (!$request->has('filtros')){
            $facturas=Factura::orderBy('id', 'asc')->get();
            $pagos_ingresos=Pago::where('pago','A')->orderBy('id', 'asc')->get();
            $pagos_egresos=Pago::where('pago','C')->orderBy('id', 'asc')->get();
            $pagos=Pago::orderBy('id', 'asc')->get();
            return view('pago.index', [
            'pagos'=>$pagos,
            'pagos_ingresos'=>$pagos_ingresos,
            'pagos_egresos'=>$pagos_egresos,
            'facturas'=>$facturas,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $facturas=Factura::all();
        $facturas_clientes=Factura::with(['cliente.entidad'])->has('cliente')->orderBy('id', 'asc')->get();
        $boletasliquidaciones=BoletaLiquidacion::all();
        return view('pago.create',[
            'facturas'=>$facturas,
            'boletasliquidaciones'=>$boletasliquidaciones,
            'facturas_clientes'=>$facturas_clientes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[ 
        'pago'=>'required',
        'fecha'=>'required', 
        'monto'=>'required', 
        'descrip_movimiento'=>'required',
        'n_doc'=>'required', 
        'sucursal'=>'required'
    ]);
        Pago::create($request->all());
        return redirect()->route('pagos.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pagos=Pago::find($id);
        return  view('pago.show',compact('pagos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         
         $facturas=Factura::all();
         $facturas_clientes=Factura::with(['cliente.entidad'])->has('cliente')->orderBy('id', 'asc')->get();
         $boletasliquidaciones=BoletaLiquidacion::all();
         $pago=Pago::findOrFail($id);
        return  view('pago.edit',compact('pago','facturas','boletasliquidaciones','facturas_clientes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $this->validate($request,[ 
            'pago'=>'required',
            'fecha'=>'required', 
            'monto'=>'required', 
            'descrip_movimiento'=>'required',
            'n_doc'=>'required', 
            'sucursal'=>'required'
        ]);
        
        Pago::find($id)->update($request->all());
        return redirect()->route('pagos.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         Pago::find($id)->delete();
        return redirect()->route('pagos.index')->with('success','Registro eliminado satisfactoriamente');
    }

    public function import(Request $request) {
        $file = $request->file("file");
        $user = Auth::user();

        // Se verifica que la carpeta temporal exista
        $dir_carga = storage_path("app/temp/carga-pago/".$user->id);
        if (!File::exists($dir_carga)) {
            File::makeDirectory($dir_carga, 0775, true);
        }

        // Se mueve el archivo a la ruta especificada
        $filename = date("YmdHis").".csv";
        $file->move($dir_carga,$filename);

        // Se instancia el job
        dispatch(new JobCargaPagos($dir_carga."/".$filename));

        // Se vuelve a la vista anterior
        return back()->withInput();
    }
}
