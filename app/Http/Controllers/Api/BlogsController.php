<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Traits\HttpResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogsController extends Controller
{
    use HttpResponseTrait;
    public function index(Request $request){
        // $blogs = Blog::all();
        $blogs = Blog::when($request->q, function($blog) use($request){
            $blog->where('title',"like","%$request->q%");
        })->get();

        // return response()->json([
        //     "message"=> "success",
        //     "status"=>"passes",
        //     "data"=>$blogs
        // ],200);

        return $this->successResponse("Successfully retrieved",$blogs);
    }


    public function search(Request $request){
        $searchblogs = Blog::when($request->q, function($searchquery) use($request){
            $searchquery->where("title","like","%$request->q%");
        })->get();

        // return response()->json([
        //     "message"=> "success",
        //     "status"=>"passes",
        //     "data"=>$searchblogs
        // ],200);
        return $this->successResponse("Successfully retrieved",$searchblogs,200);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            "title"=>"required",
            "body"=>"required"
        ]);

        if($validator->fails()){
            // return response()->json([
            //     "message"=> "Validator fails",
            //     "status" => "fails",
            //     "data"=>$validator->messages()
            // ],500);

            return $this->errorResponse("Validator fails",$validator->messages());
        }

        $blog = Blog::create([
            "title"=> $request->title,
            "body"=> $request->body
        ]);

        // return response()->json([
        //     "message"=> "Successfully created",
        //     "status"=> "passes",
        //     "data"=>$blog
        // ],201);
        return $this->successResponse("Successfully created",$blog,201);
    }

    public function show($id){
        $blogs = Blog::findOrFail($id);
        return $blogs;
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(),[
            "title"=>"required",
            "body"=>"required"
        ]);

        $blog = Blog::findOrFail($id);

        if($validator->fails()){
            return $this->errorResponse("Validator fails",$validator->messages());
        }

        $blog->update([
            "title"=> $request->title,
            "body"=> $request->body
        ]);

        return $this->successResponse("Successfully updated",$blog,200);
    }

    public function destroy($id){
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return $this->successResponse("Successfully deleted",null,200);
    }
}
