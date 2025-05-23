<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\HttpResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{

    use HttpResponseTrait;
    public function index(Request $request){

        $categories = Category::when($request->q, function($catetory) use($request){
            $catetory->where('name',"like","%$request->q%");
        })->get();
        

        return $this->successResponse("Successfully retrieved",$categories);
    }


    public function search(Request $request){
        $searchcategory = Category::when($request->q, function($searchquery) use($request){
            $searchquery->where("name","like","%$request->q%");
        })->get();

        return $this->successResponse("Successfully retrieved",$searchcategory,200);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            "name"=>"required",
        ]);

        if($validator->fails()){
            return $this->errorResponse("Validator fails",$validator->messages());
        }

        $category = Category::create([
            "name"=> $request->name,
        ]);

        return $this->successResponse("Successfully created",$category,201);
    }

    public function show($id){
        $catgories = Category::findOrFail($id);
        return $catgories;
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(),[
            "name"=>"required"
        ]);

        $category = Category::findOrFail($id);

        if($validator->fails()){
            return $this->errorResponse("Validator fails",$validator->messages());
        }

        $category->update([
            "name"=> $request->name
        ]);

        return $this->successResponse("Successfully updated",$category,200);
    }

    public function destroy($id){
        $category = Category::findOrFail($id);
        $category->delete();

        return $this->successResponse("Successfully deleted",null,200);
    }
    
}
