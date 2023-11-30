<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function login(Request $request){

        if(auth()->guard('employee')->attempt([
            'username' => $request->username,
            'password' => $request->password,
            'status' => true
        ])){

            $user = auth()->guard('employee')->user();

            return response()->json([
                'success' => true,
                'message' => 'login successfully',
                'data' => [
                    'token' => $user->createToken('mobile_token')->plainTextToken,
                    'user' => $user
                ]
            ]);

        }

        return response()->json([
            'success' => false,
            'message' => 'unauthorized',
            'data' => null
        ], 401);

    }

    public function updateProfile(Request $request){
        $request->user()->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'update profile successfully',
            'data' => null
        ]);
    }

}
