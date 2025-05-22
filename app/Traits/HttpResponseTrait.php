<?php

namespace App\Traits;

trait HttpResponseTrait
{

    public function successResponse($message,$data,$statuscode = 200){
        return response()->json([
            "message"=> $message,
            "status"=>"passes",
            "data"=>$data
        ],$statuscode);
    }

    public function errorResponse($message,$data,$statuscode = 500){
        return response()->json([
            "message"=> $message,
            "status"=>"passes",
            "data"=>$data
        ],$statuscode);
    }

}
