<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pago;
use App\Factura;
use App\BoletaLiquidacion;
use Auth;
use File;
use App\Jobs\JobCargaPagos;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pago_ingresos=Pago::where('ine','ingreso')->orderBy('id', 'asc')->get();
        $pagos_egresos=Pago::where('ine','egreso')->orderBy('id', 'asc')->get();

        $pagos=Pago::orderBy('id', 'asc')->paginate(10);
        return view('pago.index', [
            'pagos'=>$pagos,
            'pago_ingresos'=>$pago_ingresos,
            'pagos_egresos'=>$pagos_egresos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $facturas=Factura::all();
        $boletasliquidaciones=BoletaLiquidacion::all();
        return view('pago.create',[
            'facturas'=>$facturas,
            'boletasliquidaciones'=>$boletasliquidaciones
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
        'factura_id'=>'required',
        'boleta_liquidacion_id'=>'required',
        'ine'=>'required',
        'fecha_pago'=>'required', 
        'monto'=>'required', 
        'monto_total_transf'=>'required', 
        'descrip_movimiento'=>'required'
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
        $boletasliquidaciones=BoletaLiquidacion::all();
         $pago=Pago::findOrFail($id);
        return  view('pago.edit',compact('pago','facturas','boletasliquidaciones'));
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
        $this->validate($request,[ 
            'factura_id'=>'required',
            'boleta_liquidacion_id'=>'required',
            'ine'=>'required',
            'fecha_pago'=>'required',
            'monto'=>'required',
            'monto_total_transf'=>'required',
            'descrip_movimiento'=>'required'
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
