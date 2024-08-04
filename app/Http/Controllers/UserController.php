<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function changepassword(Request $request){
        
        $id=request('idusuario');
        $password=request('contra');
        $obj=User::findOrFail($id);
        $obj->password=Hash::make($password);
        $obj->save();
        return redirect()->route('users')->with('mensaje','Password cambiado!');
    }

    function create(Request $request){
        $medicos = User::where('status',1);
        return view('usuarios.create',['medicos'=>$medicos]);
    }
    function edit($id){
        $usuario=User::find($id);
        return view('usuarios.edit',['usuario'=>$usuario]);
    }
    function update(Request $request){
        try {
            $id=request('id');
            $usuario=User::findOrFail($id);
            $usuario->name=request('name');
            $usuario->email=request('email');
            $usuario->role=request('role');
            $usuario->status=request('status');
            $usuario->save();
            return redirect()->route('users')->with('mensaje','Registro Actualizado Correctamente!');
        } catch (\Throwable $th) {
            return redirect()->route('users')->with('error','Ocurrió un error durante el registro');
        }

    }

    public function register(Request $request){
        //Recepcionamos los datos para validar
        $rules=[
            'name' => 'required|string|max:255',
            'email'=> 'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:8',
            'role' => 'required|string|max:255',
        ];

        $messages=[
            'name.required' => 'El nombre del usuario es obligatorio',
            'email.required' => 'El correo electrónico es obligatorio',
            'password.required' => 'El password requiere mínimo 8 caracteres',
            'role.required' => 'Require Rol',

        ];

        $this->validate($request, $rules, $messages);       

        //Creamos el usuario
        $user = User::create([
            'name'=> $request->input('name'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($request->input('password')),
            'role'=>$request->input('role'),
        ]);

        return redirect()->route('users')->with('mensaje','Registro Creado Correctamente!');
    }


    public function change_status(Request $request, $id_user)
    {

        try {

            $status_user=$request->input('status_user');
            $user = User::findOrFail($id_user);
            $user->status=$status_user;
            $user->save(); // Actualiza el estado del usuario
            return response()->json(['message' => 'Status cambiado correctamente'],200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'server error'],500);
        }

    }

    public function users(Request $request){
        // try {
            $user = Auth::user();
            
            // Verificar el rol del usuario y redirigir según el rol
            if ($user->role === 'admin') {
                $users = User::all();
                return view('usuarios.index',['users'=>$users]);
            } elseif ($user->role === 1 ||$user->role === 2) {
                return view('messages.noautorizado');
            } else {
                // Manejar otro caso si es necesario
                abort(403, 'No tienes permisos suficientes para acceder a esta página.');
            }

            
            // return response()->json(['usuarios' => $users],200);
        // } catch (\Throwable $th) {
        //     // return response()->json(['message' => 'server error'],500);
        // }
    }
}
