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
        // ->where('trabajadores.estado','=',1)
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
        ->where('trabajadores.estado','=',1)
        ->whereDate('planillas.fecha','=',$fecha)
        ->select(
            'planillas.id',
            'trabajadores.documento',
            'trabajadores.nombre',
            'trabajadores.apellido',
            'trabajadores.cargo',
            'planillas.desayuno',
            'planillas.almuerzo',
            'planillas.cena'
        )
        ->get();


        $desayuno_recogido = $planillas->filter(function ($planillas) {
            return $planillas->desayuno == 1;
        })->count();

        $almuerzo_recogido = $planillas->filter(function ($planillas) {
            return $planillas->almuerzo == 1;
        })->count();

        $cena_recogido = $planillas->filter(function ($planillas) {
            return $planillas->cena == 1;
        })->count();


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
            'fecha'=>$fecha,
            'desayuno_recogido'=>$desayuno_recogido,
            'almuerzo_recogido'=>$almuerzo_recogido,
            'cena_recogido'=>$cena_recogido,

            ], 200);
    }
    

    public function checkcomida($codigo, $comida,$fecha) {
        // Define el campo de comida y su valor
        $campoComida = '';
        $valorComida = 1;
    
        if ($comida == 'desayuno') {
            $campoComida = 'desayuno';
        } else if ($comida == 'almuerzo') {
            $campoComida = 'almuerzo';
        } else if ($comida == 'cena') {
            $campoComida = 'cena';
        } else {
            // Manejo de casos en los que el tipo de comida no es válido
            return response()->json(['message' => 'Tipo de comida inválido'], 400);
        }
    
        
        //Verifica si trabajador está habilitado:
        $trabajador_habilitado = DB::table('trabajadores')
        ->where('trabajadores.documento', '=', $codigo)
        ->where('trabajadores.estado', '=', 0)
        ->first();

        if ($trabajador_habilitado) {
            return response()->json(['message' => 'El trabajador se encuentra inhabilitado '], 409);
        }
        
        
        // Verifica el estado actual del campo de comida
        $registro = DB::table('planillas')
            ->leftjoin('trabajadores','trabajadores.id','=','planillas.trabajador_id')
            ->where('trabajadores.estado', '=', 1)
            ->where('codigo', '=', $codigo)
            ->where($campoComida,'=',$valorComida)
            ->whereDate('fecha', '=', $fecha)
            ->first();
        
        if ($registro && $registro->$campoComida == $valorComida) {
            $nombre_trabajador=$registro->apellido." ".$registro->nombre;
            return response()->json(['message' => 'El ticket ya fue checkeado: '.$nombre_trabajador], 409);
        }


        // Actualiza el registro en la base de datos
        DB::table('planillas')
            ->where('codigo', '=', $codigo)
            ->whereDate('fecha','=',$fecha)
            ->update([$campoComida => $valorComida]);
    
        $registro = DB::table('planillas')
            ->leftjoin('trabajadores','trabajadores.id','=','planillas.trabajador_id')
            ->where('codigo', '=', $codigo)
            ->where($campoComida,'=',$valorComida)
            ->whereDate('fecha', '=', $fecha)
            ->first();

            if ($registro) {
                $nombre_trabajador=$registro->apellido." ".$registro->nombre;
            }

        return response()->json(['message' => 'Ticker chekeado: '.$nombre_trabajador], 200);
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
    public function ticket(Request $request)
    {
        
        $planilla=DB::table('planillas')
        ->leftjoin('trabajadores','trabajadores.id','=','planillas.trabajador_id')
        ->leftjoin('empresas','empresas.id','=','trabajadores.empresa_id')
        ->whereDate('planillas.fecha','=',$request->buscar_fecha_planilla)
        ->where('empresas.id','=',$request->buscar_empresa)
        ->select('planillas.id','trabajadores.nombre','trabajadores.apellido','planillas.codigo')
        ->get();
        
        return view('planillas.impresion_ticket',compact('planilla'));


    }
    public function ticket_index(Request $request){
        $empresas = empresas::select('id','nombre')->get();

        return view('planillas.ticket',compact('empresas'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(planillas $planillas)
    {
        //
    }
}
