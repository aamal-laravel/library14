<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
<<<<<<< Updated upstream
=======
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
>>>>>>> Stashed changes
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('category',  'authors')->get();
        // return $books;  
        $books = BookResource::collection($books);
        return apiSuccess("All books", $books);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        //    return $request->all()ook;
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



    /**
     * Update the specified resource in storage.
     */
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
<<<<<<< Updated upstream
        $book->update($data);
        if ($request->has('authors')){
            // $book->authors()->detach($book->authors);
            // $book->authors()->attach($request->authors);
            $book->authors()->sync($request->authors);
        }
        return apiSuccess('book updated sucessfully' , $book->load('authors'));
=======
        $book = DB::transaction(function () use ($data , $book) {
          
            if (! empty($data['authors'] ?? null) ){
                $book->authors()->sync($data['authors']);
            }
        });
        return apiSuccess('book updated sucessfully', $book->load('authors'));
>>>>>>> Stashed changes
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //delete image        
        //delete record        
    }


public function SearchBook(Request $request)
{
    $books = Book::with(['authors', 'category'])

        ->when($request->title, function ($q) use ($request) {
            $q->where('title', 'LIKE', "%{$request->title}%");
        })

        ->when($request->author, function ($q) use ($request) {
            $q->whereHas('authors', function ($author) use ($request) {
                $author->where('first_name', 'LIKE', "%{$request->author}%");
            });
        })

        ->when($request->category, function ($q) use ($request) {
            $q->whereHas('category', function ($category) use ($request) {
                $category->where('name', 'LIKE', "%{$request->category}%");
            });
        })

        ->when($request->from_date, function ($q) use ($request) {
            $q->whereDate('created_at', '>=', $request->from_date);
        })

        ->when($request->to_date, function ($q) use ($request) {
            $q->whereDate('created_at', '<=', $request->to_date);
        })

        ->paginate(10);

    return apiSuccess(
        'تم جلب الكتب بنجاح',
        BookResource::collection($books),
        200
    );
}

}
