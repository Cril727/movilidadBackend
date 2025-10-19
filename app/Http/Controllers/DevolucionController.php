<?php

namespace App\Http\Controllers;

use App\Models\Devolucione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DevolucionController extends Controller
{
    //
    // Obtener todos
    public function index()
    {
        $users = Devolucione::all();
    
        if (!$users) {
            return response()->json(["message" => "Error al obtener los usuarios"], 500);
        }
    
        return response()->json(['success' => true, 'users' => $users], 200);
    }
    
    //Obtener por Id
    public function userById($id)
    {
        $user = Devolucione::find($id);
    
        if (!$user) {
            return response()->json(['message' => 'No se ha encontrado el usuario'], 404);
        }
    
        return response()->json(['success' => true, 'usuario' => $user]);
    }
    
    //Crear
    public function store(Request $request)
    {
        try {
            $validated = Devolucione::make($request->all(), [
                "name" => "required|string",
                "email" => "required|email",
                "rol_id" => "required|numeric",
                "password" => "required|string",
            ]);
    
            if ($validated->fails()) {
                return response()->json(["errors" => $validated->errors()]);
            }
    
            $user = Devolucione::create([
                "name" => $request->name,
                "email" => $request->email,
                "rol_id" => $request->rol_id,
                "password" => $request->password,
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
            $user = Devolucione::find($id);
    
            if (!$user) {
                return response()->json(['message' => 'No se ha encontrado el usuario'], 401);
            }
    
            $validated = Validator::make($request->all(), [
                "name" => "string",
                "email" => "email",
                "rol_id" => "numeric",
                "password" => "string",
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
        $user = Devolucione::find($id);
    
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
        $users = Devolucione::with('rol')
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
