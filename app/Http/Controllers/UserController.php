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
        return view('usuarios.create');
    }
    function edit($id){
        $usuario=User::find($id);
        return view('usuarios.edit',['usuario'=>$usuario]);
    }
    function update(Request $request){
        try {
            $id = $request->input('id');
            $usuario = User::findOrFail($id);
    
            // Verifica si el usuario es "admin"
            if ($usuario->role !== 'admin') {
                // Solo actualiza el rol y el estado si el usuario no es "admin"
                $usuario->role = $request->input('role');
                $usuario->status = $request->input('status');
                $usuario->name = $request->input('name');
                $usuario->email = $request->input('email');
            }
    
            // Actualiza los campos comunes para todos los roles
            $usuario->name = $request->input('name');
            $usuario->email = $request->input('email');
            $usuario->save();
    
            return redirect()->route('users')->with('mensaje', 'Registro Actualizado Correctamente!');
        } catch (\Throwable $th) {
            return redirect()->route('users')->with('error', 'Ocurrió un error durante el registro');
        }
    }
    

    public function register(Request $request){
        //Recepcionamos los datos para validar
        $rules=[
            'name' => 'required|string|max:255',
            'email'=> 'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:5',
            'role' => 'required|string|max:255',
        ];

        $messages=[
            'name.required' => 'El nombre del usuario es obligatorio',
            'email.required' => 'El correo electrónico es obligatorio',
            'password.required' => 'El password requiere mínimo 5 caracteres',
            'role.required' => 'Require Rol',

        ];

        $this->validate($request, $rules, $messages);       

        
        //Creamos el usuario
        $user = User::create([
            'name'=> $request->input('name'),
            'email'=>$request->input('email'),
            'role'=>$request->input('role'),
            'password'=>Hash::make($request->input('password')),
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
            } elseif ($user->role === "admin" ||$user->role === "asistente") {
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
