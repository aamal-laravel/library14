<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'category_name' => $this->whenLoaded('category', fn() =>  $this->category->name) ,
            'authors' =>  $this->whenLoaded('authors' , fn() => $this->authors),
            $this->mergeWhen(1==2 , [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]),
            'total' => $this->when(1==2 , $this->rental_price + $this->deposit),
            'cover' => asset("storage/book-images/" . ($this->cover ?? "no-image.png")),
            
        ];
    }
}
