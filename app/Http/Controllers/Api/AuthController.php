<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // login api
    public function login(Request $request)
    {
        // validate the request
        $request->validate([
            'email' =>'required|email',
            'password' => 'required',
        ]);

        // cek email
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return response()->json([
                'status' => 'error',
                'error' => 'User not found'
            ], 404);
        }

        // cek password
        if(!Hash::check($request->password, $user->password)){
            return response()->json([
               'status' => 'error',
                'error' => 'Invalid password'
            ], 401);
        }

        // generate token


        // generate a new token for the user
        $token = $user->createToken('auth-token')->plainTextToken;

        // return the token and user details
        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => $user,
        ], 200);
    }
}
