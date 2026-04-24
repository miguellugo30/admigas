<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request )
    {
        $fields = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $fields['email'])
                    ->first();

        if (!$user || !Hash::check($fields['password'],$user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales son incorrectas.'],
            ]);
        }

        return response()->json([
            'token' => "",
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout exitoso','success' => true]);
    }

    function loginClient(Request $request)  {

        $fields = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $fields['email'])
                    ->first();

        if (!$user || !Hash::check($fields['password'],$user->password)) {
            return response()->json([
                "success" => false,
                "message" => "Las credenciales son incorrectas."
            ]);
        }

        if ($user->tipo == 1) {
            return response()->json([
                'token' => "",
                'user' => $user,
                "success" => true
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "No exite un usuario registrado con los datos proporcionados."
            ]);
        }


    }

}
