<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidad;
use ValidateRequests;

class ClienteController extends Controller
{

    public function index()
    {
        $clientes=Entidad::has('cliente')->orderBy('id', 'asc')->get();
        return view('cliente.index', [
            'clientes'=>$clientes
        ]);

    }

    public function create()
    {
        return view('cliente.create');
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
            'nombre_fantasia'=>'required'
        ]);
        $entidad=Entidad::where("rut", $request->rut)->first();
        if ($entidad == null) {
            $entidad=Entidad::create([
                'rut' =>$request->rut,
                'id_tipo_entidad' => 1,
                'razon_social' =>$request->razon_social,
                'nombre_fantasia' =>$request->nombre_fantasia,
                'nombre_contacto_fin' =>$request->nombre_contacto_fin,
                'nombre_contacto_tec' =>$request->nombre_contacto_tec,
                'fono_contacto_fin' =>$request->fono_contacto_fin,
                'fono_contacto_tec' =>$request->fono_contacto_tec,
                'email_contacto_fin' =>$request->email_contacto_fin,
                'email_contacto_tec' =>$request->email_contacto_tec
            ]);
            $request->session()->flash('alert-success','Se agrego exitosamente.');
        }else{
            $request->session()->flash('alert-danger','El rut ya existe en la base de datos.');
        }
        
        return redirect()->route('clientes.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $cliente=TipoEntidad::with([
            "entidad"    
        ])->findOrFail($id);
        return  view('cliente.show',compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $cliente=Entidad::findOrFail($id);
        return  view('cliente.edit',compact('cliente'));
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
            'nombre_fantasia'=>'required'
        ]);
        $entidad=Entidad::where("rut", $request->rut)->first();
        if ($entidad !== null) {
            $request->session()->flash('alert-danger', 'los datos del cliente ya existen en el sistema.');
            return redirect()->route('clientes.index');
        }
        Entidad::where("id", $entidad->id)->update([
            'rut'=>$request->rut,
            'razon_social'=>$request->razon_social,
            'nombre_fantasia'=>$request->nombre_fantasia,
            'nombre_contacto_fin'=>$request->nombre_contacto_fin,
            'nombre_contacto_tec'=>$request->nombre_contacto_tec,
            'fono_contacto_fin'=>$request->fono_contacto_fin,
            'fono_contacto_tec'=>$request->fono_contacto_tec,
            'email_contacto_fin'=>$request->email_contacto_fin,
            'email_contacto_tec'=>$request->email_contacto_tec,
            'activo'=>$request->activo
        ]);
        $request->session()->flash('alert-success', 'Registro actualizado satisfactoriamente');
        return redirect()->route('clientes.index');
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Entidad::findOrFail($id)->delete();

         $request->session()->flash('alert-success', 'Registro eliminado satisfactoriamente');
        return redirect()->route('clientes.index');
   
    }
}
