<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gasto;
use App\Trabajador;
class GastoController extends Controller
{
    public function index()
    {
    	$trabajadores=Trabajador::orderBy('id', 'asc')->get();
        $gastos=Gasto::orderBy('id', 'asc')->get();
        return view('gasto.index', [
            'gastos'=>$gastos,
            'trabajadores'=>$trabajadores
        ]);
    }

    public function create()
    {
    	$trabajadores=Trabajador::all();
        return view('gasto.create',[
            'trabajadores'=>$trabajadores
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
        'trabajador_id'=>'required', 
        'monto'=>'required',
        'descrip'=>'required'

    ]);
        Gasto::create($request->all());
        return redirect()->route('gastos.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gastos=Gasto::find($id);
        return  view('gasto.show',compact('gastos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$trabajadores=Trabajador::all();
         $gastos=Gasto::findOrFail($id);
        return  view('gasto.edit',compact('trabajadores','gastos'));
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
        'trabajador_id'=>'required', 
        'monto'=>'required',
        'descrip'=>'required'
        ]);
 
        Gasto::find($id)->update($request->all());
        return redirect()->route('gastos.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         Gasto::find($id)->delete();
        return redirect()->route('gastos.index')->with('success','Registro eliminado satisfactoriamente');
    }
}
