<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register (Request $req)
    {
        $validation = Validator::make($req->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validation->fails()){
            return response()->json($validation->errors(), 403);
        }

        $data = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password)
        ]);

        $token = $data->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'type_token' => 'Bearer',
            'message' => 'Successfully created',
            'data' => $data
        ], 201);

    }

}
