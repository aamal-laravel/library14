<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
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
            // return $request->cover;
            $filename = "$request->ISBN." .  $request->file('cover')->extension();
            $request->file('cover')->storeAs('book-images', $filename);
            $data['cover'] = $filename;
        }

        $book = DB::transaction(function () use ($data) {

            $book = Book::create($data);

            if (!empty($data['authors'] ?? null)) {
                $book->authors()->attach($data['authors']);
            }

            return $book;
        });

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
        $book = DB::transaction(function () use ($data , $book) {
          
            if (! empty($data['authors'] ?? null) ){
                // $book->authors()->detach($book->authors);
                // $book->authors()->attach($request->authors);
                $book->authors()->sync($data['authors']);
            }
        });
        return apiSuccess('book updated sucessfully', $book->load('authors'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
       

        $book->delete();

        return apiSuccess('Book deleted successfully');
    }
}
