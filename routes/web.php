<?php

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   return view('welcome');
});

/** test route */
Route::get('test/{year?}', function (?int $y = 2000) {
   return "The name is: $y";
})->where('year', '[0-9]{4}');

Route::get('test/{name}', function ($name) {
   return "The name is: $name";
});

Route::get('model-bind/{b}', function (Book $b) {
   return $b;
});

Route::get('route-parameter/{name}', function (Request $request) {
   return $request->route('name');
});

/** helpers */
Route::get('helpers', function (Request $request) {
   // return  new Response("test");
   return response("test"); //using helper function
});
/**relation */
Route::get('1-m-child/{id}', function ($id) {
   $category = Category::find($id);
   $books = $category->books;
   return $books;
});
Route::get('1-m-parent/{id}', function ($id) {
   $book = Book::find($id);
   $category =  $book->category;
   return $category;
});
Route::get('relation-update/{id}', function ($id) {
   $category = Category::find($id);
   $category->books()->update(['rental_price' => DB::raw('0.9 * rental_price')]);
   return "books updated";
});
Route::get('has', function () {
   $categories = Category::has('books')->get();
   return $categories;
});
Route::get('has-where', function () {
   $categories = Category::wherehas('books', function ($q) {
      return $q->where('rental_price', '<', 3);
   })->get();
   return $categories;
});
Route::get('with-avg', function () {
   $categories =  Category::withAvg('books', 'rental_price')->get();
   return $categories;
});

Route::get('with-count', function () {
   $categories =  Category::withCount(['books' => function ($q) {
      return $q->where('stock', '>', 0);
   }])->get();
   return $categories;
});


/** env- config */
Route::get('env', function () {
   return env('APP_NAME', 'not found');
});
Route::get('config', function () {
   return config('app.name', 'not found');
});

/** file  system */
Route::get('file-system', function () {
   return storage_path('app');
});

/** model-2 */
Route::get('raw-select', function () {
   $books = Book::select("rental_price as price", "deposit", DB::raw('rental_price + deposit as total'))->get();
   return $books;
});

/** collection */
Route::get('collect', function () {
   $array = [
      ['id' => 1, 'name' => 'Ali'],
      ['id' => 2, 'name' => 'Sara'],
   ];
   $users = collect($array);
   return   $users->max('id');
});
