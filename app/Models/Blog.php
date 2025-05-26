<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = "blogs";
    protected $primaryKey = "id";
    protected $fillable = [
        "category_id",
        'title',
        'body', 
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
