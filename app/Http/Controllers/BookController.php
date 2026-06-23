<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
   
    public function index()
    {
        $books = Book::with('category',  'authors')->get();
         
        $books = BookResource::collection($books);
        return apiSuccess("All books", $books);
    }

    public function store(BookRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('cover')) {
            $filename = "$request->ISBN." .  $request->file('cover')->extension();
            $request->file('cover')->storeAs('book-images', $filename);
            $data['cover'] = $filename;
        }

        $book = Book::create(
            $data
        );

        if ($request->has('authors')) {
            $book->authors()->attach($request->authors);
        }
        return apiSuccess(data: $book, code: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book = $book->load('category', 'authors');
        $book = new BookResource($book);
        return apiSuccess(data: $book);
    }


    public function update(BookRequest $request, Book $book)
    {
        $data = $request->validated();
        if ($request->hasfile('cover')) {
            if ($book->cover)
                Storage::delete("book-images/$book->cover");
            $filename = "$request->ISBN." .  $request->file('cover')->extension();
            $request->file('cover')->storeAs('book-images', $filename);
            $data['cover'] = $filename;
        }
        $book = DB::transaction(function () use ($data , $book) {
          
            if (! empty($data['authors'] ?? null) ){
                $book->authors()->sync($data['authors']);
            }
        });
        return apiSuccess('book updated sucessfully', $book->load('authors'));
    }

    public function destroy(Book $book)
    {
          Gate::authorize('delete',$book);
            if ($book->cover) {
                Storage::delete("book_image/" . $book->cover);
            }
            $book->delete();
        return apiSuccess("the book is deleted");
    }


public function SearchBook(Request $request)
{
    
    $filters = $request->only(['title', 'author', 'category', 'from_date', 'to_date']);

    $books = Book::with(['authors', 'category'])
        ->filter($filters) 
        ->paginate(10);

    return apiSuccess(
        'تم جلب الكتب بنجاح',
        BookResource::collection($books),
        200
    );
}


   public function bookCount (){
        $books=Book::all()->count();
        return $books;
    }

    public function trendBook (){
     $books=Book::with('category')->take(6)->get();
     return $books;
}


public function DeleteManyBook (Request $request) {
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'exists:authors,id'
    ]);
    $ids = $request->input('ids'); 
    $books=Book::whereIn('id',$ids)->get();
    foreach($books as $book){
        if(Auth::user()->cannot('delete',$book)){
            return apiFail("You UnAuthorized to Delete this book",code:403);
        }
    }
    Book::whereIn('id', $ids)->delete();
    return apiSuccess("تم الحذف بنجاح", code: 200); 
}

}
