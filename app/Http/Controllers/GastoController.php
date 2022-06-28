<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gasto;
use App\Trabajador;
use App\Entidad;

class GastoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('total_gastado')) {
            $gastos = Gastos::count();
            $mensual_clientes = Entidad::has('gastos')->sum('monto');
            $mensual_trabajadores = Trabajador::has('gastos')->sum('monto');
            $total_mensual = $mensual_clientes + $mensual_trabajadores;
            return response()->json([
                'gastos' => $gastos,
                'mensual_clientes' => $mensual_clientes,
                'mensual_trabajadores' => $mensual_trabajadores,
                'total_mensual' => $total_mensual
            ]);
        } elseif (!$request->has('filtros')) {
            $gastos_trabajador = Trabajador::whereHas('gastos', function ($query) {
                $query->where('gastable_type', 'like', 'trabajador');
            })->get();
            $gastos_cliente = Entidad::has('cliente')->has('gastos')->get();
            return view('gasto.index', [
                'gastos_trabajador' => $gastos_trabajador,
                'gastos_cliente' => $gastos_cliente
            ]);
        } else {
            $fecha = $request->filtros['fecha'];
            $reembolsable = $request->filtros['reeembolsable'];
        };
    }

    public function create()
    {
        $trabajadores = Trabajador::all();
        $clientes = Entidad::has('cliente')->get();
        return view('gasto.create', [
            'trabajadores' => $trabajadores,
            'clientes' => $clientes,
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
        $this->validate($request, [
            'gastable_id' => 'required',
            'gastable_type' => 'required',
            'monto' => 'required',
            'descrip' => 'required',
            'reembolso' => 'required',
            'fecha_gasto' => 'required'

        ]);
        Gasto::create($request->all());
        return redirect()->route('gastos.index')->with('success', 'Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gastos = Gasto::find($id);
        return  view('gasto.show', compact('gastos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gasto = Gasto::findOrFail($id);
        if ($gasto->gastable_type == 'cliente') {
            $clienteOrTrabajador = Entidad::findORFail($gasto->gastable_id);
            $lista = Entidad::has('cliente')->get();
            foreach($lista as $li){
                $li->nombre = $li->nombre_fantasia;
            }
        } else {
            $clienteOrTrabajador = Trabajador::findORFail($gasto->gastable_id);
            $lista = Trabajador::all();
            foreach($lista as $li){
                $li->nombre = $li->nombres.$li->apellidoP;
            }        
        }
        return view('gasto.edit', compact('gasto', 'clienteOrTrabajador', 'lista'));
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
        $this->validate($request, [
            'monto' => 'required',
            'descrip' => 'required',
            'reembolso' => 'required',
            'fecha_gasto' => 'required'
        ]);
        Gasto::find($id)->update($request->all());
        return redirect()->route('gastos.index')->with('success', 'Registro actualizado satisfactoriamente');
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
        return redirect()->route('gastos.index')->with('success', 'Registro eliminado satisfactoriamente');
    }
}
