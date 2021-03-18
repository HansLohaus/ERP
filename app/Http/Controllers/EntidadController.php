<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidad;
use Freshwork\ChileanBundle\Rut;

class EntidadController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entidades=Entidad::orderBy('id', 'asc')->paginate(3);
        return view('entidad.index', [
            'entidades'=>$entidades
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('entidad.create');
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
        'rut'=>'required|cl_rut', 
        'razon_social'=>'required', 
        'nombre_fantasia'=>'required',
        'nombre_contacto_fin'=>'required', 
        'nombre_contacto_tec'=>'required', 
        'fono_contacto_fin'=>'required', 
        'fono_contacto_tec'=>'required', 
        'email_contacto_fin'=>'required|email', 
        'email_contacto_tec'=>'required|email', 
        'activo'=>'required'
    ]);
        Entidad::create($request->all());
        return redirect()->route('entidades.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $entidades=Entidad::find($id);
        return  view('entidad.show',compact('entidades'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entidad=Entidad::findOrFail($id);
        return  view('entidad.edit',compact('entidad'));
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
            'rut'=>'required|cl_rut', 
            'razon_social'=>'required', 
            'nombre_fantasia'=>'required',
            'nombre_contacto_fin'=>'required', 
            'nombre_contacto_tec'=>'required', 
            'fono_contacto_fin'=>'required', 
            'fono_contacto_tec'=>'required', 
            'email_contacto_fin'=>'required', 
            'email_contacto_tec'=>'required', 
            'activo'=>'required'
        ]);
 
        Entidad::find($id)->update($request->all());
        return redirect()->route('entidades.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         Entidad::find($id)->delete();
        return redirect()->route('entidades.index')->with('success','Registro eliminado satisfactoriamente');
    }
}
