<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,            
            'full_name'  => $this->first_name . ' ' . $this->last_name,
            'email'      => $this->email,
            // 'birth_date' => $this->{'birth-date'}, 
            'birth_date' => $this->{'birth_date'}, // لأن الاسم فيه -
            'bio'        => $this->bio,
        ];
    }
}