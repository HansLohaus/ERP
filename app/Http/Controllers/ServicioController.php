<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicio;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios=Servicio::orderBy('id', 'asc')->paginate(10);
        return view('servicio.index', [
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
        return view('servicio.create');
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
         $servicio=Servicio::findOrFail($id);
        return  view('servicio.edit',compact('servicio'));
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
