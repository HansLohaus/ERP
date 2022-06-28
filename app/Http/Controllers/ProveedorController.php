<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidad;
use ValidateRequests;

class ProveedorController extends Controller
{
    public function index()
    {

        $proveedores = Entidad::has('proveedor')->orderBy('id', 'asc')->get();
        return view('proveedor.index', [
            'proveedores' => $proveedores
        ]);
    }
    public function create()
    {
        return view('proveedor.create');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'rut' => 'required|cl_rut',
            'razon_social' => 'required',
            'nombre_fantasia' => 'required',
            'nombre_contacto_fin' => 'required',
            'nombre_contacto_tec' => 'required',
            'fono_contacto_fin' => 'required',
            'fono_contacto_tec' => 'required',
            'email_contacto_fin' => 'required|email',
            'email_contacto_tec' => 'required|email'
        ]);
        $entidad = Entidad::where("rut", $request->rut)->first();
        if ($entidad == null) {
            $entidad = Entidad::create([
                'rut' => $request->rut,
                'id_tipo_entidad' => 2,
                'razon_social' => $request->razon_social,
                'nombre_fantasia' => $request->nombre_fantasia,
                'nombre_contacto_fin' => $request->nombre_contacto_fin,
                'nombre_contacto_tec' => $request->nombre_contacto_tec,
                'fono_contacto_fin' => $request->fono_contacto_fin,
                'fono_contacto_tec' => $request->fono_contacto_tec,
                'email_contacto_fin' => $request->email_contacto_fin,
                'email_contacto_tec' => $request->email_contacto_tec
            ]);
        }
        return redirect()->route('proveedores.index')->with('success', 'Registro creado satisfactoriamente');
    }

    public function show($id)
    {
        $proveedor = Entidad::findOrFail($id);
        return  view('proveedor.show', compact('proveedor'));
    }
    public function edit($id)
    {

        $proveedor = Entidad::findOrFail($id);
        return  view('proveedor.edit', compact('proveedor'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'rut' => 'required|cl_rut',
            'razon_social' => 'required',
            'nombre_fantasia' => 'required',
            'nombre_contacto_fin' => 'required',
            'nombre_contacto_tec' => 'required',
            'fono_contacto_fin' => 'required',
            'fono_contacto_tec' => 'required',
            'email_contacto_fin' => 'required|email',
            'email_contacto_tec' => 'required|email'
        ]);
        $entidad=Entidad::where("rut", $request->rut)->first();
        if ($entidad !== null) {
            $request->session()->flash('alert-danger', 'los datos del proveedor ya existen en el sistema.');
            return redirect()->route('proveedores.index');
        }
        Entidad::where("id", $entidad->id)->update([
            'rut' => $request->rut,
            'razon_social' => $request->razon_social,
            'nombre_fantasia' => $request->nombre_fantasia,
            'nombre_contacto_fin' => $request->nombre_contacto_fin,
            'nombre_contacto_tec' => $request->nombre_contacto_tec,
            'fono_contacto_fin' => $request->fono_contacto_fin,
            'fono_contacto_tec' => $request->fono_contacto_tec,
            'email_contacto_fin' => $request->email_contacto_fin,
            'email_contacto_tec' => $request->email_contacto_tec
        ]);
        $request->session()->flash('alert-success', 'Registro actualizado satisfactoriamente');
        return redirect()->route('proveedores.index');
    }

    public function destroy(Request $request, $id)
    {
        Entidad::findOrFail($id)->delete();

        $request->session()->flash('alert-success', 'Registro eliminado satisfactoriamente');
        return redirect()->route('proveedores.index');
    }
}
