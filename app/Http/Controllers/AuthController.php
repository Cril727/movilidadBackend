<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function loginPorRol(Request $request, $rolEsperado)
    {
        $validated = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required|string"
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        $credenciales = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credenciales)) {
            return response()->json(['success' => false, 'errors' => 'Credenciales inválidas'], 401);
        }

        $user = JWTAuth::user();

        if ($user->rol->rol !== $rolEsperado) {
            // Cierra sesión inmediatamente
            JWTAuth::invalidate($token);
            return response()->json(['success' => false, 'errors' => 'Acceso no autorizado'], 403);
        }

        return response()->json([
            'success' => true,
            'message' => "Bienvenido $rolEsperado",
            'token' => $token,
            'user' => $user
        ]);
    }

    public function loginAdmin(Request $request)
    {
        return $this->loginPorRol($request, 'admin');
    }

    public function loginUsuario(Request $request)
    {
        return $this->loginPorRol($request, 'user');
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $e) {
            return response()->json(['error' => 'Error al cerar la sesion, intentalo nuevamente'], 500);
        }
        return response()->json(['message' => 'Sesion cerrada correctamente']);
    }

    public function me()
    {
        $user = JWTAuth::user();

        return response()->json(["user" => $user]);
    }
}
