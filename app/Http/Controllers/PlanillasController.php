<?php

namespace App\Http\Controllers;

use App\Models\planillas;
use App\Models\empresas;
use App\Models\proveedores;
use Illuminate\Http\Request;
use DB;

class PlanillasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   

        $planillas=[];
        $empresas = empresas::select('id','nombre')->get();
        $proveedores = proveedores::select('id','nombre')->get();
        return view('planillas.index',compact('planillas','empresas','proveedores'));
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
        
        $existe_planilla=DB::table('planillas')
        ->leftjoin('trabajadores','trabajadores.id','=','planillas.trabajador_id')
        ->leftjoin('empresas','empresas.id','=','trabajadores.empresa_id')
        ->where('trabajadores.empresa_id','=',$request->empresa_id)
        ->where('planillas.fecha','=',$request->fecha_planilla)->exists();
        if ($existe_planilla) {
            return response()->json(['message'=>'Ya existe una planilla con esta fecha y empresa.!!'], 200);
        }

        $trabajadores= DB::table('trabajadores')
        ->where('trabajadores.empresa_id','=',$request->empresa_id)
        ->where('trabajadores.estado','=',1)
        ->select('trabajadores.empresa_id','trabajadores.id','trabajadores.documento')
        ->get();

        foreach ($trabajadores as $trab) {
            $codigo = $trab->documento;
            $planilla = new planillas();
            $planilla->trabajador_id = $trab->id;
            $planilla->proveedores_id = $request->proveedor;
            $planilla->codigo = $codigo;
            $planilla->area = $request->area;
            $planilla->fecha = $request->fecha_planilla;
            $planilla->desayuno = false;
            $planilla->almuerzo = false;
            $planilla->cena = false;
            $planilla->save();
        }
        return response()->json(['message'=>'Se ha registrado planilla satisfactoriamente'], 200);
               

    }

    /**
     * Display the specified resource.
     */
    public function show($fecha,$empresa)
    {

        
        $planillas=DB::table('planillas')
        ->leftjoin('trabajadores','trabajadores.id','=','planillas.trabajador_id')
        ->leftjoin('empresas','empresas.id','=','trabajadores.empresa_id')
        ->where('trabajadores.empresa_id','=',$empresa)
        ->whereDate('planillas.fecha','=',$fecha)
        ->select(
            'trabajadores.id',
            'trabajadores.documento',
            'trabajadores.nombre',
            'trabajadores.apellido',
            'trabajadores.cargo',
            'planillas.desayuno',
            'planillas.almuerzo',
            'planillas.cena'
        )
        ->get();

        if ($planillas->count()<1) {
            return response()->json(['data'=>[],'message'=>'No existen registros con la fecha y la empresa seleccionada.'], 200);
        }

        $solodatos=DB::table('planillas')
        ->leftjoin('trabajadores','trabajadores.id','=','planillas.trabajador_id')
        ->leftjoin('empresas','empresas.id','=','trabajadores.empresa_id')
        ->leftjoin('proveedores','proveedores.id','=','planillas.proveedores_id')
        ->where('trabajadores.empresa_id','=',$empresa)
        ->whereDate('planillas.fecha','=',$fecha)
        ->select(
            'empresas.nombre as nombre_empresa',
            'proveedores.nombre as nombre_proveedor',
            'planillas.area as area',
            'planillas.fecha as fecha'
            )
        ->first();

        $empresa = $solodatos->nombre_empresa;
        $proveedor = $solodatos->nombre_proveedor;
        $area = $solodatos->area;
        $fecha = $solodatos->fecha;

        return response()->json([
            'data'=>$planillas,
            'empresa'=>$empresa,
            'proveedor'=>$proveedor,
            'area'=>$area,
            'fecha'=>$fecha], 200);
    }
    

    public function checkcomida($codigo, $comida) {
        // Define el array de actualización basado en el tipo de comida
        $updateData = [];
        if ($comida == 'desayuno') {
            $updateData['desayuno'] = 1;
        } else if ($comida == 'almuerzo') {
            $updateData['almuerzo'] = 1;
        } else if ($comida == 'cena') {
            $updateData['cena'] = 1;
        } else {
            // Manejo de casos en los que el tipo de comida no es válido
            return response()->json(['message' => 'Tipo de comida inválido'], 400);
        }
    
        // Actualiza el registro en la base de datos
        DB::table('planillas')
            ->where('codigo', '=', $codigo)
            ->update($updateData);
    
        return response()->json(['message' => 'correcto'], 200);
    }
    

    public function checkestado($id,$comida,$estado)
    {
        $updateData = [];
        if ($comida == 'desayuno') {
            $updateData['desayuno'] = $estado;
        } else if ($comida == 'almuerzo') {
            $updateData['almuerzo'] = $estado;
        } else if ($comida == 'cena') {
            $updateData['cena'] = $estado;
        } else {
            // Manejo de casos en los que el tipo de comida no es válido
            return response()->json(['message' => 'Tipo de comida inválido'], 400);
        }

        DB::table('planillas')
            ->where('planillas.id', '=', $id)
            ->update($updateData);
    
        return response()->json(['message' => 'correcto'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, planillas $planillas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(planillas $planillas)
    {
        //
    }
}