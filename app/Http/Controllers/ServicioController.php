<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicio;
use App\TipoEntidad;
class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios_clientes=Servicio::with(['cliente.entidad'])->has('cliente')->orderBy('id', 'asc')->get();
        $servicios_proveedores=Servicio::with(['proveedor.entidad'])->has('proveedor')->orderBy('id', 'asc')->get();
        $servicios=Servicio::all();
        return view('servicio.index', [
            'servicios_clientes'=>$servicios_clientes,
            'servicios_proveedores'=>$servicios_proveedores,
            'servicios'=>$servicios
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes=TipoEntidad::clientes()->get();
        $proveedores=TipoEntidad::proveedores()->get();
        return view('servicio.create',[
            'clientes'=>$clientes,
            'proveedores'=>$proveedores
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
            'nombre'=>'required', 
            'fecha_inicio'=>'required', 
            'fecha_fin'=>'required', 
            'tipo'=>'required', 
            'estado'=>'required', 
            'numero_propuesta'=>'required', 
            'condicion_pago'=>'required']);
        Servicio::create($request->all());
        return redirect()->route('servicios.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $servicios=Servicio::find($id);
        return  view('servicio.show',compact('servicios'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clientes=TipoEntidad::clientes()->get();
        $proveedores=TipoEntidad::proveedores()->get();
         $servicio=Servicio::findOrFail($id);
        return  view('servicio.edit',compact('servicio','clientes','proveedores'));
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
            'nombre'=>'required', 
            'fecha_inicio'=>'required', 
            'fecha_fin'=>'required', 
            'tipo'=>'required', 
            'estado'=>'required', 
            'numero_propuesta'=>'required', 
            'condicion_pago'=>'required']);
 
        Servicio::find($id)->update($request->all());
        return redirect()->route('servicios.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Servicio::find($id)->delete();
        return redirect()->route('servicios.index')->with('success','Registro eliminado satisfactoriamente');
    }
}
