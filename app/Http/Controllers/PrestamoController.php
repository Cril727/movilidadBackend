<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PrestamoController extends Controller
{
    //
    // Obtener todos
    public function index()
    {
        $loans = Prestamo::all();
    
        if (!$loans) {
            return response()->json(["message" => "Error al obtener los prestamos"], 500);
        }
    
        return response()->json(['success' => true, 'loans' => $loans], 200);
    }
    
    //Obtener por Id
    public function loanById($id)
    {
        $loan = Prestamo::find($id);
    
        if (!$loan) {
            return response()->json(['message' => 'No se ha encontrado el prestamo'], 404);
        }
    
        return response()->json(['success' => true, 'prestamo' => $loan]);
    }
    
    //Crear
    public function store(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                "fecha_inicio" => "required",
                "tarifa_recorrido" => "required|numeric",
                "user_id" => "required|numeric",
                "bicicleta_id" => "required|numeric",
            ]);
    
            if ($validated->fails()) {
                return response()->json(["errors" => $validated->errors()]);
            }
    
            $loan = Prestamo::create([
                "fecha_inicio" => $request->fecha_inicio,
                "tarifa_recorrido" => $request->tarifa_recorrido,
                "user_id" => $request->user_id,
                "bicicleta_id" => $request->bicicleta_id,
            ]);
    
            return response()->json(["success" => true, "message" => "Prestamo creado correctamente", "loan" => $loan]);
        } catch (\Throwable $th) {
            Log::error('Error al crear', ['error' => $th->getMessage()]);
            return response()->json(['message' => "Error interno del servidor", $th]);
        }
    }
    
    //Actualizar
    public function update(Request $request, $id)
    {
        try {
            $loan = Prestamo::find($id);
    
            if (!$loan) {
                return response()->json(['message' => 'No se ha encontrado el prestamo'], 401);
            }
    
            $validated = Validator::make($request->all(), [
                "fecha_inicio" => "date",
                "tarifa_recorrido" => "numeric",
                "user_id" => "numeric",
                "bicicleta_id" => "numeric",
            ]);
    
            if ($validated->fails()) {
                return response()->json(["errors" => $validated->errors()], 422);
            }
    
            $actualizar = $loan->update($validated->validated());
    
            if (!$actualizar) {
                return response()->json(["message" => "No se ha podido actualizar el prestamo"], 500);
            }
    
            return response()->json(['success' => true, 'message' => 'Actualizado correctamente', 'prestamo' => $loan], 200);
        } catch (\Throwable $th) {
            Log::error('Error al actualizar', ['error' => $th->getMessage()]);
            return response()->json(['message' => "Error interno del servidor", $th]);
        }
    }
    
    //Eliminar
    public function delete($id)
    {
        $loan = Prestamo::find($id);
    
        if (!$loan) {
            return response()->json(['message' => 'No se ha encontrado el prestamo'], 401);
        }
    
        try {
            $loan->delete();
            return response()->json(['message' => 'Eliminado correctamente'], 200);
        } catch (\Throwable $th) {
            Log::error('Error al eliminar', ['error' => $th->getMessage()]);
            return response()->json(['message' => 'No se pudo eliminar el prestamo', $th], 500);
        }
    }
    
    
}
