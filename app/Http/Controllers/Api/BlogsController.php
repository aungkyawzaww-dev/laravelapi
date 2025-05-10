<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    public function index(){
        $blogs = Blog::all();
        return $blogs;
    }

    public function show($id){
        $blogs = Blog::findOrFail($id);
        return $blogs;
    }
}
