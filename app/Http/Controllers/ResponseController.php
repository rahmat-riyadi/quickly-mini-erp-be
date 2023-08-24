<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseController extends Controller
{
    static function create($data , $success, $message, $statusCode){
        return response()->json([
            'status' => $statusCode,
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }
}
