<?php

namespace App\Http\Controllers;

use App\Models\Bicicleta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BiciletaController extends Controller
{
    //
    // Obtener todos
    public function index()
    {
        $bicycle = Bicicleta::all();

        if (!$bicycle) {
            return response()->json(["message" => "Error al obtener las Bicicletas"], 500);
        }

        return response()->json(['success' => true, 'bicycle' => $bicycle], 200);
    }

    //Obtener por Id
    public function bicyclesById($id)
    {
        $bicycle = Bicicleta::find($id);

        if (!$bicycle) {
            return response()->json(['message' => 'No se ha encontrado la Bicicleta'], 404);
        }

        return response()->json(['success' => true, 'bicycle' => $bicycle]);
    }

    //Crear
    public function store(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                "marca" => "required|string",
                "color" => "required|string",
                "estado" => "required|string",
                "precioAlquiler" => "required|numeric",
                "regional_id" => "required|numeric",
            ]);

            if ($validated->fails()) {
                return response()->json(["errors" => $validated->errors()]);
            }

            $bicycle = Bicicleta::create([
                "marca" => $request->marca,
                "color" => $request->color,
                "estado" => $request->estado,
                "precioAlquiler" => $request->precioAlquiler,
                "regional_id" => $request->regional_id,
            ]);

            return response()->json(["success" => true, "message" => "Bicicleta creado correctamente", "bicycle" => $bicycle]);
        } catch (\Throwable $th) {
            Log::error('Error al crear', ['error' => $th->getMessage()]);
            return response()->json(['message' => "Error interno del servidor", $th]);
        }
    }

    //Actualizar
    public function update(Request $request, $id)
    {
        try {
            $bicycle = Bicicleta::find($id);

            if (!$bicycle) {
                return response()->json(['message' => 'No se ha encontrado la bicicleta'], 401);
            }

            $validated = Validator::make($request->all(), [
                "marca" => "string",
                "color" => "string",
                "estado" => "string",
                "precioAlquiler" => "numeric",
                "regional_id" => "numeric",
            ]);

            if ($validated->fails()) {
                return response()->json(["errors" => $validated->errors()], 422);
            }

            $actualizar = $bicycle->update($validated->validated());

            if (!$actualizar) {
                return response()->json(["message" => "No se ha podido actualizar el la bicicleta"], 500);
            }

            return response()->json(['success' => true, 'message' => 'Actualizado correctamente', 'bicycle' => $bicycle], 200);
        } catch (\Throwable $th) {
            Log::error('Error al actualizar', ['error' => $th->getMessage()]);
            return response()->json(['message' => "Error interno del servidor", $th]);
        }
    }

    //Eliminar
    public function delete($id)
    {
        $bicycle = Bicicleta::find($id);

        if (!$bicycle) {
            return response()->json(['message' => 'No se ha encontrado la bicicleta'], 401);
        }

        try {
            $bicycle->delete();
            return response()->json(['message' => 'Eliminado correctamente'], 200);
        } catch (\Throwable $th) {
            Log::error('Error al eliminar', ['error' => $th->getMessage()]);
            return response()->json(['message' => 'No se pudo eliminar la bicicleta', $th], 500);
        }
    }

}
