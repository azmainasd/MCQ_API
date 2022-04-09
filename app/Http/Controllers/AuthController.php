<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'password'       => 'required|min:5'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'isSuccess' => false,
                'message'     => $validator,
                'data'      => null
              ], 422);
        }else{
            $credentials = request(['email' , 'password']);
            if(Auth::attempt($credentials)){
                return response()->json([
                    'isSuccess' => true,
                    'message'   => 'Login Successfully!',
                    'data'      =>  Auth::user()
                ], 200);
            }else{
                return response()->json([
                    'isSuccess' => true,
                    'message'   => 'Invalid email or password',
                    'data'      => null
                ], 200);
            }
            
        }

       
    }


    public function register(Request $request){
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'name'           => 'required',
            'email'          => 'required|unique:users|email',
            'password'       => 'required|min:5'
        ]);

        $user = New User([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
        $user->save();

        if ($validator->fails()) {
            return response()->json([
                'isSuccess' => false,
                'message'     => $validator,
                'data'      => null
              ], 422);
        }else{
            return response()->json([
                'isSuccess' => true,
                'message'   => 'User Created Successfully!',
                'data'      => null
            ], 200);
        }
    }

    public function logout(){  
        Auth::logout();
    }
}
