<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\book_stock_operationController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ِِAuthController;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Book;
use App\Models\book_stock_operation;
use App\Models\Category;
use App\Models\Customer;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('categories', [CategoryController::class, "index"]);
Route::get('category/{category}', [CategoryController::class, "show"]);
Route::apiResource('books', BookController::class)->only('index' ,'show');

 
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{category}', [CategoryController::class, 'update']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
    Route::post('/operationStock',[book_stock_operationController::class,'store']);
    Route::apiResource('books', BookController::class)->except('index', 'show');
    Route::apiResource('authors', AuthorController::class)->except('index', 'show');
    Route::post('/operationStock',[book_stock_operationController::class,'store']);
});





//Counts 
Route::prefix('/Counts')->group(function(){
Route::get('/Books',[BookController::class,'bookCount']);
Route::get('/category',[CategoryController::class,'CategoryCount']);
Route::get('/author',[AuthorController::class,'AuthorCount']);
Route::get('/AddStock',[book_stock_operationController::class,'theOperationAdd']);
Route::get('/hasNobook',[AuthorController::class,'HasNoBook']);
});

Route::prefix('/deletemulti')->group(function(){
Route::delete('/author',[AuthorController::class,'DeleteManyAuthor']);
Route::delete('/books',[BookController::class,'DeleteManyBook']);
});

//for Landing page
Route::get('/treandBook',[BookController::class,'trendBook']);

//for return Category that have books
Route::get('categoryhasbooks',[CategoryController::class,'HasBook']);





//for delete more than elemente
Route::prefix('/deletemulti')->group(function(){
Route::delete('/author',[AuthorController::class,'DeleteManyAuthor']);
Route::delete('/books',[BookController::class,'DeleteManyBook']);
});
Route::get('book-search',[BookController::class,'SearchBook']);





Route::controller(ِِAuthController::class)->group(function () {
    Route::post('register',  'register');
    Route::post('login',  'login');
    Route::post('logout',  'logout')->middleware('auth:sanctum');;
});