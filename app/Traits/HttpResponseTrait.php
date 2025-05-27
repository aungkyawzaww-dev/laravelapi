<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

trait HttpResponseTrait
{

    public function successResponse($message,$data,$statuscode = 200){

        if($data->resource instanceof LengthAwarePaginator){
            $data = $data->response()->getdata();
        }

        return response()->json([
            "message"=> $message,
            "status"=>"passes",
            "data"=>$data
        ],$statuscode);


        // return response()->json([
        //     "message"=> $message,
        //     "status"=>"passes",
        //     "data"=>$data->response()->getdata()
        // ],$statuscode);
    }

    public function errorResponse($message,$data,$statuscode = 500){
        return response()->json([
            "message"=> $message,
            "status"=>"passes",
            "data"=>$data
        ],$statuscode);
    }

}
