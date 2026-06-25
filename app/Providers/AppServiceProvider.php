<?php

namespace App\Providers;

use App\Models\Author;
use App\Models\Book;
use App\Models\book_stock_operation;
use App\Observers\AuthorObserver;
use App\Observers\BookObserver;
use App\Observers\OpreationOnStockObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        //
    }

 
    public function boot(): void
    {
        book_stock_operation::observe(OpreationOnStockObserver::class);
        Book::observe(BookObserver::class);
        Author::observe(AuthorObserver::class);
    }
}
