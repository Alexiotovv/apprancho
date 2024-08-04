<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pagos;
use App\Models\expedientes;
use App\Models\deudores;
use DB;
use Carbon\Carbon;


class HomeController extends Controller
{
    public function index(){
        return view('home');
    }

    // public function datos(){
    //     $pagos = DB::select('CALL sp_scc_pagos()');
    //     $aperturados=expedientes::where('noaperturado',0)->count();
    //     $noaperturados=expedientes::where('noaperturado',1)->count();
    //     $totalexpedientes=expedientes::all()->count();
    //     $totalejecutados=deudores::all()->count();
    //     return response()->json(['status'=>'success','data'=>[
    //         'pagos'=>$pagos,
    //         'aperturados'=>$aperturados,
    //         'noaperturados'=>$noaperturados,
    //         'totalexpedientes'=>$totalexpedientes,
    //         'totalejecutados'=>$totalejecutados,
    //     ]]);
    // }
}
