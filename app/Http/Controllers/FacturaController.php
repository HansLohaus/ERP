<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facturas=Factura::orderBy('id', 'asc')->paginate(3);
        return view('factura.index', [
            'facturas'=>$facturas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('factura.create');
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
        'cliente_id'=>'required', 
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
        $factura=Factura::findOrFail($id);
        return  view('factura.edit',compact('factura'));
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
            'cliente_id'=>'required', 
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
}
