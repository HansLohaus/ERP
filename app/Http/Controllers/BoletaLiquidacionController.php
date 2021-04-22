<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BoletaLiquidacion;
use App\Trabajador;
class BoletaLiquidacionController extends Controller
{
     public function index()
    {
        $trabajadores=Trabajador::orderBy('id', 'asc')->get();
        $boletasliquidaciones=BoletaLiquidacion::orderBy('id', 'asc')->paginate(10);
        
        $boletas=BoletaLiquidacion::where('boleta_liq','boleta')->orderBy('id', 'asc')->get();
        $liquidaciones=BoletaLiquidacion::where('boleta_liq','liquidacion')->orderBy('id', 'asc')->get();

        return view('boletaliquidacion.index', [
            'boletasliquidaciones'=>$boletasliquidaciones,
            'trabajadores'=>$trabajadores,
            'boletas'=>$boletas,
            'liquidaciones'=>$liquidaciones
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $trabajadores=Trabajador::all();
        return view('boletaliquidacion.create',[
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
        'descripcion'=>'required',
        'monto_total'=>'required', 
        'monto_liquido'=>'required' 
        
    ]);
        BoletaLiquidacion::create($request->all());
        return redirect()->route('boletasliquidaciones.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $boletasliquidaciones=BoletaLiquidacion::find($id);
        return  view('boletaliquidacion.show',compact('boletasliquidaciones'));
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
         $boletaliquidacion=BoletaLiquidacion::findOrFail($id);
        return  view('boletaliquidacion.edit',compact('boletaliquidacion','trabajadores'));
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
        'descripcion'=>'required',
        'monto_total'=>'required',
        'monto_liquido'=>'required'
        ]);
 
        BoletaLiquidacion::find($id)->update($request->all());
        return redirect()->route('boletasliquidaciones.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         BoletaLiquidacion::find($id)->delete();
        return redirect()->route('boletasliquidaciones.index')->with('success','Registro eliminado satisfactoriamente');
    }
}
