<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pago;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagos=Pago::orderBy('id', 'asc')->paginate(10);
        return view('pago.index', [
            'pagos'=>$pagos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pago.create');
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
         $pago=Pago::findOrFail($id);
        return  view('pago.edit',compact('pago'));
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
}
