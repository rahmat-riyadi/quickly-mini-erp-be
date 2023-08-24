<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login (Request $request){
        if(Auth::guard('cashier')->attempt(['username' => $request->username, 'password' => $request->password])){
            $user = Auth::guard('cashier')->user();
            $token = $user->createToken('token')->plainTextToken;
            $data = [
                'token' => $token,
                'type' => 'cashier',
                'user' => $user
            ];
            return ResponseController::create($data, true, 'login successfully', 200);
        }

        if(Auth::attempt(['email' => $request->username, 'password' => $request->password])){
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $data = [
                'token' => $token,
                'type' => $user->role,
                'user' => $user
            ];
            return ResponseController::create($data, true, 'login successfully', 200);
        }

        return ResponseController::create(null, false, 'Username or Password inccorect', 401);

    }
}
