<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        $validated = Validator::make($request->all(),[
            "email" => "required|email",
            "password" => "required|string"
        ]);
    
        if($validated->fails()){
            return response()->json(['errors' => $validated->errors()],422);
        }
    
        $credenciales = $request->only('email','password');
    
        if(!$token = JWTAuth::attempt($credenciales)){
            return response()->json(['success' => false, 'errors' => 'credenciales invalidas'],401);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Bienvenido',
            'token' => $token
        ]);
    }
}
