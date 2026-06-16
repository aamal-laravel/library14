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
            'ISBN' => $this->ISBN,
            'title' => $this->title,

            'rental_price' => $this->rental_price,
            'deposit' => $this->deposit,
            'total' =>  $this->rental_price + $this->deposit,

            'pages' => $this->pages,
            'default_borrow_days' => $this->default_borrow_days,
            'total_copies' => $this->total_copies,
            'stock' => $this->stock,
            'published_at' => $this->published_at,
            
            'cover' => asset("storage/book-images/" . ($this->cover ?? "no-image.png")),

            /** add key when key exist for avoid lazy loading */
            'category_name' => $this->whenLoaded('category', fn() =>  $this->category->name),            
            'authors' => AuthorResource::collection($this->whenLoaded('authors')),


            // /** add a bunch of keys based on creteria  */
            // $this->mergeWhen(1==2 , [
            //     'created_at' => $this->created_at,
            //     'updated_at' => $this->updated_at,
            // ]),
            // /** add a key based on creteria  */
            // 'total' => $this->when(1==2 , $this->rental_price + $this->deposit),

        ];
    }
}
