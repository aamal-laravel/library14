<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'gender' => $this->gender,
            'DOB' => $this->DOB,
            'phone' => $this->phone,
            'lang' => $this->lang,


            'name' => $this->whenLoaded('user', $this->user->name),
            'email' => $this->whenLoaded('user', $this->user->email),

            // avatar URL بشكل صحيح
            'avatar' => asset("storage/" . ($this->avatar ?? "no-image.png")),
        ];
    }
}
