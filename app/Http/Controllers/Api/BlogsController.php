<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Traits\HttpResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Validator;


class BlogsController extends Controller
{
    use HttpResponseTrait;
    public function index(Request $request){
        // $blogs = Blog::all();
        // $blogs = Blog::when($request->q, function($blog) use($request){
        //     $blog->where('title',"like","%$request->q%");
        // })->get();


        $blogs = BlogResource::collection(
            Blog::when($request->q, function($blog) use($request){
                $blog->where('title',"like","%$request->q%");
            })->paginate(3)
        );

        // return response()->json([
        //     "message"=> "success",
        //     "status"=>"passes",
        //     "data"=>$blogs
        // ],200);


        // return $blogs;
        return $this->successResponse("Success",$blogs);
        // return $this->successResponse("Successfully show",BlogResource::collection($blogs));
        

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
        return $this->successResponse("Successfully searched",$searchblogs,200);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            "category_id"=>"required",
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

        //method 1
        // $blog = Blog::create([
        //     "category_id"=> $request->category_id,
        //     "title"=> $request->title,
        //     "body"=> $request->body
        // ]);

        // method 2
        $blog = Blog::create($validator->validated());

        // method 1
        // return response()->json([
        //     "message"=> "Successfully created",
        //     "status"=> "passes",
        //     "data"=>$blog
        // ],201);

        // method 2
        return $this->successResponse("Successfully created",$blog,201);
    }

    public function show($id){
        $blogs = Blog::findOrFail($id);
        return $blogs->category;
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(),[
            "category_id"=>"required",
            "title"=>"required",
            "body"=>"required"
        ]);

        $blog = Blog::findOrFail($id);

        if($validator->fails()){
            return $this->errorResponse("Validator fails",$validator->messages());
        }

        $blog->update([
            "category_id"=> $request->category_id,
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
