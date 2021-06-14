<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{

     /**
     * register
     *
     * @param  mixed $request
     * @return void
     */
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|',
            'email' => 'required|unique:donaturs|email',
            'password' =>  'required|min:8|confirmed'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        try {
            $donatur =  Donatur::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

        $response = [
            'success' => true,
            'message' => 'Register Successfully',
            'user' => $donatur,
            'token'   => $donatur->createToken('authToken')->accessToken
        ];
        return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'error' => $e
            ]);
        }
    }
}
