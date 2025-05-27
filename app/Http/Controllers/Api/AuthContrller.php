<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\HttpResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthContrller extends Controller
{

    use HttpResponseTrait;

    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:6"
        ]);

        if ($validator->fails()){
            return $this->errorResponse("Validator fails",$validator->messages());
        }

        $user = User::create([
            "name" => $request->name,
            "email"=> $request->email,
            "password" => Hash::make($request->password)
        ]);

        return $this->successResponse("Successfully created",$user,201);

    }

    public function login(){
        return "login";
    }

    public function logout(){
        return "logout";
    }

}
