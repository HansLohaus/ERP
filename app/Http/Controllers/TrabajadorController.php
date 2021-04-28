<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trabajador;
use Freshwork\ChileanBundle\Rut;
class TrabajadorController extends Controller
{
    public function index()
    {
        $trabajadores=Trabajador::orderBy('id', 'asc')->get();
        return view('trabajador.index', [
            'trabajadores'=>$trabajadores
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('trabajador.create');
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
        'nombres'=>'required', 
        'apellidoP'=>'required',
        'apellidoM'=>'required',
        'rut'=>'required|cl_rut',
        'fecha_nac'=>'required',
        'direccion'=>'required',
        'cargo'=>'required', 
        'profesion'=>'required',
        'sueldo'=>'required', 
        'fecha_contrato'=>'required',
        'fono'=>'required', 
        'email'=>'required|email'
    ]);
        Trabajador::create($request->all());
        return redirect()->route('trabajadores.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trabajadores=Trabajador::find($id);
        return  view('trabajador.show',compact('trabajadores'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $trabajador=Trabajador::findOrFail($id);
        return  view('trabajador.edit',compact('trabajador'));
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
        'nombres'=>'required', 
        'apellidoP'=>'required',
        'apellidoM'=>'required',
        'rut'=>'required|cl_rut',
        'fecha_nac'=>'required',
        'direccion'=>'required',
        'cargo'=>'required', 
        'profesion'=>'required',
        'sueldo'=>'required', 
        'fecha_contrato'=>'required',
        'fono'=>'required', 
        'email'=>'required|email'
        ]);
 
        Trabajador::find($id)->update($request->all());
        return redirect()->route('trabajadores.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         Trabajador::find($id)->delete();
        return redirect()->route('trabajadores.index')->with('success','Registro eliminado satisfactoriamente');
    }
}
