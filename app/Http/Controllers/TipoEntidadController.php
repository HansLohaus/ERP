<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TipoEntidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipoentidades=TipoEntidad::orderBy('id', 'asc')->paginate(3);
        return view('tipoentidad.index', [
            'tipoentidades'=>$tipoentidades
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tipoentidad.create');
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
        'entidades_id'=>'required', 
        'tipo'=>'required'
    ]);
        TipoEntidad::create($request->all());
        return redirect()->route('tipoentidades.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $tipoentidades=TipoEntidad::find($id);
        return  view('tipoentidad.show',compact('tipoentidades'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipoentidad=TipoEntidad::findOrFail($id);
        return  view('tipoentidad.edit',compact('tipoentidad'));
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
        'entidades_id'=>'required', 
        'tipo'=>'required'
    	]);
        TipoEntidad::find($id)->update($request->all());
        return redirect()->route('tipoentidades.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         TipoEntidad::find($id)->delete();
        return redirect()->route('tipoentidades.index')->with('success','Registro eliminado satisfactoriamente');
    }
}
