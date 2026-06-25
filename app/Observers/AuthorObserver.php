<?php

namespace App\Observers;

use App\Models\Author;
use Illuminate\Support\Facades\Cache;

class AuthorObserver
{
    
    public function created(Author $author): void
    {
        Cache::forget('authors');
    }

    
    public function updated(Author $author): void
    {
         Cache::forget('authors');
    }

   
    public function deleted(Author $author): void
    {
         Cache::forget('authors');
    }

}
