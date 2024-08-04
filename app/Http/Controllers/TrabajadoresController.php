<?php

namespace App\Http\Controllers;

use App\Models\trabajadores;
use Illuminate\Http\Request;

class TrabajadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cargos = trabajadores::distinct()->pluck('cargo');
        $trabajadores = trabajadores::all();
        return view('trabajadores.index', compact('trabajadores','cargos'));
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
        $trabajadores = new trabajadores();
        $trabajadores->documento = request('documento');
        $trabajadores->nombre = request('nombre');
        $trabajadores->apellido = request('apellido');
        $trabajadores->cargo = request('cargo');
        $trabajadores->estado = request('estado');
        $trabajadores->save();

        return redirect()->route('trabajadores.index')->with(['mensaje' => 'Registro Creado','color' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(trabajadores $trabajadores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $trabajador=trabajadores::find($id);
        return response()->json($trabajador, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, trabajadores $trabajadores)
    {
        $id_trabajado=inpue('id_trabajador');
        $trabajadores = trabajadores::findOrFail($id_trabajado);
        $trabajadores->nombre = input('edit_nombre');
        $trabajadores->apellido = input('edit_apellido');
        $trabajadores->cargo = input('edit_cargo');
        $trabajadores->estado = input('edit_estado');
        $trabajadores->save();

        return redirect()->route('trabajadores.index')->with(['mensaje' => 'Registro Actualizado','color' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(trabajadores $trabajadores)
    {
        $id_trabajador = request('id_registro_eliminar');
        $existe_datos=asignaciones::where('trabajador_id',$id_trabajador)->exists();
        if ($existe_datos) {
            return redirect()->route('trabajadores.index')->with(['mensaje' => 'El registro no se puede eliminar, contiene datos','color' => 'warning']);
        }
        $trabajadores=trabajadores::find($id_trabajador);
        
        if ($trabajadores) {
            $trabajadores->delete();
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
