<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use App\Factura;
use App\TipoEntidad;
use App\Servicio;

use App\Jobs\JobCargaFacturas;
use File;
class FacturaController extends Controller
{
    use DispatchesJobs;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\|Response
     */
    public function index(Request $request)
    {
        if ($request->has('totales')){
            if ($request->totales=='cliente') {
                $facturas=Factura::has('cliente')->count();
                $pagadas=Factura::has('cliente')->where('estado','pagado')->count();
                $pendientes=Factura::has('cliente')->where('estado', '!=','pagado')->count();
            }elseif ($request->totales=='proveedor') {
                $facturas=Factura::has('proveedor')->count();
                $pagadas=Factura::has('proveedor')->where('estado','pagado')->count();
                $pendientes=Factura::has('proveedor')->where('estado', '!=','pagado')->count();
            }
            return response()->json([
                'facturas'=>$facturas,
                'pagadas'=>$pagadas,
                'pendientes'=>$pendientes
            ]);
            
        }elseif (!$request->has('filtros')){
            $facturas_clientes=Factura::with(['cliente.entidad'])->has('cliente')->orderBy('id', 'asc')->get();
            $facturas_proveedores=Factura::with(['proveedor.entidad'])->has('proveedor')->orderBy('id', 'asc')->get();
            $servicios=Servicio::orderBy('id', 'asc')->get();
            return view('factura.index', [
                'facturas_clientes'=>$facturas_clientes,
                'facturas_proveedores'=>$facturas_proveedores,
                'servicios'=>$servicios
            ]);
        }else{
            $pagados=$request->filtros['pagados'];
            $pendientes=$request->filtros['pendientes'];
            //se inicializan query
            $facturas_clientes=Factura::with(['cliente.entidad', 'servicio'])->has('cliente');
            $facturas_proveedores=Factura::with(['proveedor.entidad', 'servicio'])->has('proveedor');

            if ($pagados=='true') {
                $facturas_clientes=$facturas_clientes->where('estado','pagado');
                $facturas_proveedores=$facturas_proveedores->where('estado','pagado');
            }
            if ($pendientes=='true') {
                $facturas_clientes=$facturas_clientes->where('estado', '!=','pagado');
                $facturas_proveedores=$facturas_proveedores->where('estado', '!=','pagado');
            }
            $facturas_clientes=$facturas_clientes->orderBy('id', 'asc')->get();
            $facturas_proveedores=$facturas_proveedores->orderBy('id', 'asc')->get();
            foreach ($facturas_clientes as $factura) {
                $factura->fecha_emision=date_format(date_create($factura->fecha_emision),"d-m-Y");
                $factura->total_neto=number_format($factura->total_neto);
                $factura->total_exento=number_format($factura->total_exento);
                $factura->total_iva=number_format($factura->total_iva);
                $factura->total_monto_total=number_format($factura->total_monto_total);
                $factura->edit='<a class="btn btn-primary" href="'.action("FacturaController@edit", $factura->id).'" ><i class="bi bi-pencil"></i></a>';
                $factura->delete='<form action="'.action('FacturaController@destroy', $factura->id).'" method="post">'.
                   csrf_field().
                   '<input name="_method" type="hidden" value="DELETE">'.
                   '<button class="btn btn-danger" type="submit" onclick=\'return confirm("Se eliminaran todos los pagos asociados a la factura, '.
                   '¿Seguro que quieres eliminar?")\'><i class="bi bi-trash"></i></button>'.
                 '</form>';
            }
            foreach ($facturas_proveedores as $factura) {
                $factura->fecha_emision=date_format(date_create($factura->fecha_emision),"d-m-Y");
                $factura->total_neto=number_format($factura->total_neto);
                $factura->total_exento=number_format($factura->total_exento);
                $factura->total_iva=number_format($factura->total_iva);
                $factura->total_monto_total=number_format($factura->total_monto_total);
                $factura->edit='<a class="btn btn-primary" href="'.action("FacturaController@edit", $factura->id).'" ><i class="bi bi-pencil"></i></a>';
                $factura->delete='<form action="'.action('FacturaController@destroy', $factura->id).'" method="post">'.
                   csrf_field().
                   '<input name="_method" type="hidden" value="DELETE">'.
                   '<button class="btn btn-danger" type="submit" onclick=\'return confirm("Se eliminaran todos los pagos asociados a la factura, '.
                   '¿Seguro que quieres eliminar?")\'><i class="bi bi-trash"></i></button>'.
                 '</form>';
            }
            return response()->json([
                'facturas_clientes'=>$facturas_clientes,
                'facturas_proveedores'=>$facturas_proveedores
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
        $clientes=TipoEntidad::clientes()->get();
        $servicios= Servicio::all();
        return view('factura.create',[
            'clientes'=>$clientes,
            'servicios'=>$servicios
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
        'tipo_entidad_id'=>'required', 
        'servicio_id'=>'required', 
        'folio'=>'required', 
        'tipo_dte'=>'required', 
        'fecha_emision'=>'required', 
        'total_neto'=>'required', 
        'total_exento'=>'required', 
        'total_iva'=>'required', 
        'total_monto_total'=>'required',
        'estado'=>'required'
    ]);
        Factura::create($request->all());
        return redirect()->route('facturas.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $facturas=Factura::find($id);
        return  view('factura.show',compact('facturas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $servicios= Servicio::all();
        $clientes=TipoEntidad::clientes()->get();
        $factura=Factura::findOrFail($id);
        return  view('factura.edit',compact('factura','clientes','servicios'));
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
            'tipo_entidad_id'=>'required', 
            'servicio_id'=>'required', 
            'folio'=>'required', 
            'tipo_dte'=>'required', 
            'fecha_emision'=>'required', 
            'total_neto'=>'required', 
            'total_exento'=>'required', 
            'total_iva'=>'required', 
            'total_monto_total'=>'required',
            'estado'=>'required'
             ]);
 
        Factura::find($id)->update($request->all());
        return redirect()->route('facturas.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Factura::find($id)->delete();
        return redirect()->route('facturas.index')->with('success','Registro eliminado satisfactoriamente');
    }

    public function import(Request $request) {
        $file = $request->file("file");
        $user = Auth::user()->username;

        // Se verifica que la carpeta temporal exista
        $dir_carga = storage_path("app/temp/carga-factura/".$user->id);
        if (!File::exists($dir_carga)) {
            File::makeDirectory($dir_carga, 0775, true);
        }

        // Se mueve el archivo a la ruta especificada
        $filename = date("YmdHis").".csv";
        $file->move($dir_carga,$filename);

        // Se instancia el job
        dispatch(new JobCargaFacturas($dir_carga."/".$filename));

        // Se vuelve a la vista anterior
        return back()->withInput();
    }
}
