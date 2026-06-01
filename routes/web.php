<?php

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
