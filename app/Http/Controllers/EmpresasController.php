<?php

namespace App\Http\Controllers;

use App\Models\empresas;
use App\Models\asignaciones;
use Illuminate\Http\Request;

class EmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresas= empresas::all();
        return view ('empresas/index',compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cantidadEmpresas = empresas::count();

        // Verificar si la cantidad de registros es menor a 5
        if ($cantidadEmpresas < 5) {
            $empresa = new empresas();
            $empresa->nombre = $request->input('nombre');
            $empresa->estado = $request->input('estado');
            $empresa->save();
    
            return redirect()->route('empresas.index')->with(['mensaje' => 'Registro Creado','color' => 'success',
            ]);
        } else {
            return redirect()->route('empresas.index')->with(['mensaje' => 'No puede crear más de 5 empresas','color' => 'danger',]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(empresas $empresas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {   
        $empresa=empresas::find($id);
        return response()->json($empresa, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, empresas $empresas)
    {
        $id_empresa=request('id_empresa');
        
        $empresa = empresas::find($id_empresa);
        $empresa->nombre = $request->input('nombre');
        $empresa->estado = $request->input('estado');
        $empresa->save();

        return redirect()->route('empresas.index')->with(['mensaje' => 'Registro Actualizado','color' => 'success']);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(empresas $empresas)
    {
        $id_empresa = request('id_registro_eliminar');
        $existe_datos=asignaciones::where('empresa_id',$id_empresa)->exists();
        if ($existe_datos) {
            return redirect()->route('empresas.index')->with(['mensaje' => 'El registro no se puede eliminar, contiene datos','color' => 'warning']);
        }
        $empresa=empresas::find($id_empresa);
        
        if ($empresa) {
            $empresa->delete();
            return redirect()->route('empresas.index')->with([
                'mensaje' => 'Registro eliminado exitosamente',
                'color' => 'success'
            ]);
        } else {
            return redirect()->route('empresas.index')->with([
                'mensaje' => 'Registro no encontrado',
                'color' => 'danger'
            ]);
        }
    
    }
}
