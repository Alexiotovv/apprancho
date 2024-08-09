<?php

namespace App\Http\Controllers;

use App\Models\trabajadores;
use App\Models\empresas;
use App\Models\asignaciones;
use Illuminate\Http\Request;
use DB;
class TrabajadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cargos = trabajadores::distinct()->pluck('cargo');
        $trabajadores = DB::table('trabajadores')
        ->leftjoin('empresas','trabajadores.empresa_id','=','empresas.id')
        ->select('trabajadores.*','empresas.nombre as nombre_empresa')
        ->get();
        $empresas = empresas::all();
        return view('trabajadores.index', compact('trabajadores','cargos','empresas'));
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
        $request->validate([
            'documento' => 'required|unique:trabajadores,documento', // Verifica que el documento sea único
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'empresa' => 'required',
        ]);

        
        $trabajadores = new trabajadores();
        $trabajadores->documento = request('documento');
        $trabajadores->nombre = request('nombre');
        $trabajadores->apellido = request('apellido');
        $trabajadores->cargo = request('cargo');
        $trabajadores->estado = request('estado');
        $trabajadores->save();

        $asignaciones = new asignaciones();
        $asignaciones->empresa_id=request('empresa');
        $asignaciones->trabajador_id=$trabajadores->id;
        $asignaciones->estado=True;
        $asignaciones->save();

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
        $trabajador = DB::table('trabajadores')
        ->leftjoin('empresas','trabajadores.empresa_id','=','empresas.id')
        ->where('trabajadores.id','=',$id)
        ->select('trabajadores.*','empresas.id as empresa')
        ->first();
        
        return response()->json(compact('trabajador'), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        
        $request->validate([
            'id_trabajador' => 'required|exists:trabajadores,id',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
        ]);
        
        // Buscar al trabajador y actualizar sus datos
        $trabajadores = trabajadores::findOrFail($request->id_trabajador);
        $trabajadores->nombre = $request->nombre;
        $trabajadores->apellido = $request->apellido;
        $trabajadores->cargo = $request->cargo;
        $trabajadores->estado = $request->estado;
        $trabajadores->save();
    
        return redirect()->route('trabajadores.index')->with(['mensaje' => 'Registro Actualizado', 'color' => 'success']);
    }

    
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

    public function empresas($id_trabajador){
        $empresas=DB::table('asignaciones')
        ->leftjoin('empresas','empresas.id','=','asignaciones.empresa_id')
        ->leftjoin('trabajadores','trabajadores.id','=','asignaciones.trabajador_id')
        ->where('trabajadores.id','=',$id_trabajador)
        ->select('empresas.id as id','empresas.nombre as nombre_empresa','asignaciones.estado')
        ->get();
        return response()->json($empresas, 200);
    }

    public function empresas_store(Request $request){
        
        // Verifica si el trabajador ya está registrado en la empresa
        $existe_empresa_registrar = asignaciones::where('trabajador_id', $request->id_trabajador_empresa)
            ->where('empresa_id', $request->empresa_registrado)
            ->exists();    

        if ($existe_empresa_registrar) {
            return response()->json(['message' => 'El trabajador ya se encuentra registrado en esta empresa'], 200);
        }
        
        asignaciones::where('trabajador_id', $request->id_trabajador_empresa)->update(['estado' => false]);

        // Crea una nueva asignación para el trabajador en la empresa especificada
        $asignacion = new asignaciones();
        $asignacion->empresa_id = $request->empresa_registrado;
        $asignacion->trabajador_id = $request->id_trabajador_empresa;
        $asignacion->estado = true;

        $asignacion->save();

        return response()->json(['message' => 'Correcto, el trabajador se agregó a la empresa'], 200);


    }
}
