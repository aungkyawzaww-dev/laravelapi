<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            "id" => $this->id,
            "category_id" => $this->category_id,
            "title" => $this->title,
            "body" => $this->body,
            "created_at" => $this->created_at->format("d m Y"),
            "updated_at"=> $this->updated_at->format("d m Y"),
            "category" => Category::where("id",$this->category_id)->select('id',"name")->first()
        ];
    }
}
