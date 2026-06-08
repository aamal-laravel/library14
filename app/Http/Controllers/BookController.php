<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('category:id,name')->get();
        return apiSuccess("All books" , $books);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        //    return $request->all();
        $data = $request->validated();
        if ($request->hasFile('cover')){
            $filename = "$request->ISBN." .  $request->file('cover')->extension();
            $request->file('cover')->storeAs('book-images' , $filename);
            $data['cover'] = $filename;
        }
        $book = Book::create(
            $data
        );
        return apiSuccess(data: $book ,code: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book = $book->load('category');
        return apiSuccess(data: $book);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
