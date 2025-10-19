<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    // Obtener todos
    public function index()
    {
        $users = User::all();
    
        if (!$users) {
            return response()->json(["message" => "Error al obtener los usuarios"], 500);
        }
    
        return response()->json(['success' => true, 'users' => $users], 200);
    }
    
    //Obtener por Id
    public function userById($id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['message' => 'No se ha encontrado el usuario'], 404);
        }
    
        return response()->json(['success' => true, 'usuario' => $user]);
    }
    
    //Crear
    public function store(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                "name" => "required|string",
                "nombres" => "required|string",
                "apellidos" => "required|string",
                "telefono" => "required|string",
                "direccion" => "required|string",
                "email" => "required|email",
                "password" => "required|string",
                "estrato" => "required|numeric",
                "rol_id" => "required|numeric",
            ]);
    
            if ($validated->fails()) {
                return response()->json(["errors" => $validated->errors()]);
            }
    
            $user = User::create([
                "name" => $request->name,
                "nombres" => $request->nombres,
                "apellidos" => $request->apellidos,
                "telefono" => $request->telefono,
                "direccion" => $request->direccion,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "estrato" => $request->estrato,
                "rol_id" => $request->rol_id,
            ]);
    
            return response()->json(["success" => true, "message" => "Ususario creado correctamente", "user" => $user]);
        } catch (\Throwable $th) {
            Log::error('Error al crear', ['error' => $th->getMessage()]);
            return response()->json(['message' => "Error interno del servidor", $th]);
        }
    }
    
    //Actualizar
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
    
            if (!$user) {
                return response()->json(['message' => 'No se ha encontrado el usuario'], 401);
            }
    
            $validated = Validator::make($request->all(), [
                "name" => "string",
                "nombres" => "string",
                "apellidos" => "string",
                "telefono" => "string",
                "direccion" => "string",
                "email" => "email",
                "password" => "string",
                "estrato" => "numeric",
                "rol_id" => "numeric",
            ]);
    
            if ($validated->fails()) {
                return response()->json(["errors" => $validated->errors()], 422);
            }
    
            $actualizar = $user->update($validated->validated());
    
            if (!$actualizar) {
                return response()->json(["message" => "No se ha podido actualizar el usuario"], 500);
            }
    
            return response()->json(['success' => true, 'message' => 'Actualizado correctamente', 'usuario' => $user], 200);
        } catch (\Throwable $th) {
            Log::error('Error al actualizar', ['error' => $th->getMessage()]);
            return response()->json(['message' => "Error interno del servidor", $th]);
        }
    }
    
    //Eliminar
    public function delete($id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['message' => 'No se ha encontrado el usuario'], 401);
        }
    
        try {
            $user->delete();
            return response()->json(['message' => 'Eliminado correctamente'], 200);
        } catch (\Throwable $th) {
            Log::error('Error al eliminar', ['error' => $th->getMessage()]);
            return response()->json(['message' => 'No se pudo eliminar el usuario', $th], 500);
        }
    }
    
    //traer los usuarios con roles admin
    public function userByRolAdmin()
    {
        $users = User::with('rol')
            ->whereHas('rol', function ($query) {
                $query->where('rol', 'user');
            })
            ->get();
    
        if ($users->isEmpty()) {
            return response()->json(['message' => 'No hay usuarios con rol admin'], 404);
        }
    
        return response()->json(['success' => true, 'usuarios' => $users], 200);
    }
}
