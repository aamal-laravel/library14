<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\book_stock_operation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class book_stock_operationController extends Controller
{
      public function index():JsonResponse
    {
        return apiSuccess("Remove_Frome_remaining ",book_stock_operation::all(),200);
    }
public function store(Request $request)
{
    $data = $request->all();

    $book = Book::findOrFail($data['book_id']);

    if (
        $data['type'] == 'destroy' &&
        $data['remove_from_remaining'] &&
        $book->stock < $data['quantity']
    ) {
        return apiFail('Quantity exceeds available stock', 400);
    }

    if (
        $data['type'] == 'add' &&
        $data['remove_from_remaining']
    ) {
        $book->increment('stock', $data['quantity']);
    }

    if (
        $data['type'] == 'destroy' &&
        $data['remove_from_remaining']
    ) {
        $book->decrement('stock', $data['quantity']);
    }

     book_stock_operation::create($data);

    return apiSuccess(
        'Operation created successfully',
        null,
        201
    );
}

}
