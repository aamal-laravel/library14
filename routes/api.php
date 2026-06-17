<?php

<<<<<<< Updated upstream
=======
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\book_stock_operationController;
>>>>>>> Stashed changes
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

<<<<<<< Updated upstream
Route::middleware(['auth:sanctum' ,'user-type:admin'])->group(function(){    
    Route::post('categories', [CategoryController::class, "store"]);
    Route::put('categories/{category}', [CategoryController::class, "update"]);
    Route::delete('categories/{category}', [CategoryController::class, "destroy"]);
    
    Route::apiResource('books', BookController::class)->except('index' ,'show');
=======
 
Route::middleware(['auth:sanctum', 'user-type:admin'])->group(function () {
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{category}', [CategoryController::class, 'update']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
    Route::post('/operationStock',[book_stock_operationController::class,'store']);
    Route::apiResource('books', BookController::class)->except('index', 'show');
    Route::apiResource('authors', AuthorController::class)->except('index', 'show');
    Route::post('/operationStock',[book_stock_operationController::class,'store']);
>>>>>>> Stashed changes
});


Route::controller(ِِAuthController::class)->group(function () {
    Route::post('register',  'register');
    Route::post('login',  'login');
    Route::post('logout',  'logout')->middleware('auth:sanctum');;
});

<<<<<<< Updated upstream
=======

//Counts 
Route::prefix('/Counts')->group(function(){
Route::get('/Books',function(){
$books=Book::all()->count();
return $books;
});


Route::get('/category',function(){
$category=Category::all()->count();
return $category;
});

Route::get('/author',function(){
$author=Author::all()->count();
return $author;
});

//for front
Route::get('/AddStock',function(){
$author=book_stock_operation::all()->where('type',"LIKE","add")->sum('quantity');
return $author;
});

Route::get('/hasNobook',function(){
$author=Author::has('books',"=",0)->count();
return $author;
});

Route::get('users',function(){
return Customer::count();
});
});

Route::get('categoryhasbooks',function(){
    $category=Category::has('books','>',0)->get();  
     return $category;
});


//for Landing page
Route::get('/treandBook',function(){
$books=Book::with('category')->take(6)->get();
return $books;
});



//for delete more than elemente
Route::prefix('/deletemulti')->group(function(){
Route::delete('/author',function (Request $request) {
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'exists:authors,id'
    ]);
    $ids = $request->input('ids'); 
    Author::whereIn('id', $ids)->delete();
    return apiSuccess("تم الحذف بنجاح", code: 200); 
   });
   Route::delete('/books',function (Request $request) {
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'exists:authors,id'
    ]);
    $ids = $request->input('ids'); 
    Book::whereIn('id', $ids)->delete();
    return apiSuccess("تم الحذف بنجاح", code: 200); 
});
});

Route::get('book-search',[BookController::class,'SearchBook']);
>>>>>>> Stashed changes
