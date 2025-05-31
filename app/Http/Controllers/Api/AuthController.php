<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\HttpResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
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

    public function login(Request $request){

        $validator = Validator::make($request->all(),[
            "email" => "required",
            "password" => "required"
        ]);

        if($validator->fails()) {
            return $this->errorResponse("Validation fails",$validator->messages());
        }

        if( Auth::attempt($validator->validated())){

        //generate token and store to db
            $token = $request->user()->createToken("blog_auth_token")->plainTextToken;

        // response to client
            return $this->successResponse("Success login",$token);
 
        }else {
            return $this->errorResponse("The creditional does not match our record",null,401);
        }
    }

    public function logout(Request $request){

        $request->user()->tokens()->delete();
        return $this->successResponse("Successfully logout",null);

    }
 
}
