<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\WaitingList;
use App\Http\Requests\CartItemRequest;

class CartController extends Controller
{
    public function addItem(CartItemRequest $request)
    {
        $data = $request->validated();

        $customer = $request->user()->customer;

        // get or create cart
        $cart = $customer->cart()->firstOrCreate([]);

        // FIX: ISBN is primary key now
        $book = Book::where('ISBN', $data['book_id'])->firstOrFail();

        // check if book already in cart
        $exists = $cart->cartItems()
            ->where('book_id', $book->ISBN)
            ->exists();

        if ($exists) {
            return apiFail("Book already in cart");
        }

        $limit = 5;

        if ($cart->cartItems()->count() >= $limit) {
            return apiFail("Borrowing limit exceeded");
        }

        // if book not available
        if ($book->stock <= 0) {

            if (!empty($data['want_waiting'])) {

                WaitingList::create([
                    'customer_id' => $customer->id,
                    'book_id' => $book->ISBN, 
                ]);

                return apiSuccess("Added to waiting list");
            }

            return apiFail("Book not available", [
                'can_join_waiting_list' => true
            ]);
        }

        // add to cart
        $cart->cartItems()->create([
            'book_id' => $book->ISBN, 
            'rental_price' => $book->rental_price,
            'deposit' => $book->deposit,
        ]);

        return apiSuccess("Book added to cart");
    }
/*
    private function processWaitingList(Book $book)
    {
        $waiting = WaitingList::where('book_id', $book->ISBN)
            ->orderBy('id')
            ->first();

        if (!$waiting) {
            return;
        }

        $customer = $waiting->customer;

        // get or create cart
        $cart = $customer->cart()->firstOrCreate([]);

        // check if already in cart
        $exists = $cart->cartItems()
            ->where('book_id', $book->ISBN)
            ->exists();

        if (!$exists && $book->stock > 0) {

            $cart->cartItems()->create([
                'book_id' => $book->ISBN,
                'rental_price' => $book->rental_price,
                'deposit' => $book->deposit,
            ]);

            // remove from waiting list
            $waiting->delete();
        }
    }

    public function increaseStock($bookId)
    {
        // IMPORTANT: now $bookId = ISBN
        $book = Book::where('ISBN', $bookId)->firstOrFail();

        $book->increment('stock');

        $this->processWaitingList($book);

        return apiSuccess("Stock updated and waiting list processed");
    }*/
}