<?php

namespace App\Services;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\Setting;

class CheckoutService
{
    public function getCheckoutData(array $bookIds): array
    {
       $books = Book::whereIn('id', $bookIds)->get();

$depositRatio = Setting::getValue('deposit_ratio', 1.5);

        $total = 0;

        $items = [];

        foreach ($books as $book) {

            $deposit = $book->rental_price * $depositRatio;

            $items[] = [
                'book_id' => $book->id,
                'title' => $book->title,
                'rental_price' => $book->rental_price,
                'deposit_amount' => $deposit,
                'total' => $book->rental_price + $deposit,
            ];

            $total += $book->rental_price + $deposit;
        }

        return [
            'items' => $items,
            'total_amount' => $total,
        ];
    }


            public function checkout(
            Customer $customer,
            array $bookIds,
            string $paymentMethod
        ): Bill {

            return DB::transaction(function () use (
                $customer,
                $bookIds,
                $paymentMethod
            ) {

                $depositRatio = Setting::getValue(
                    'deposit_ratio',
                    1.5
                );

                $borrowDays = Setting::getValue(
                    'borrow_days',
                    14
                );

                $maxBorrowBooks = Setting::getValue(
                    'max_borrow_books',
                    3
                );

                if (count($bookIds) > $maxBorrowBooks) {
                    throw new \Exception(
                        'Borrow limit exceeded'
                    );
                }

                $books = Book::whereIn(
                    'id',
                    $bookIds
                )->lockForUpdate()->get();

                if ($books->count() !== count($bookIds)) {
                    throw new \Exception(
                        'Some books do not exist'
                    );
                }

                $totalAmount = 0;

                foreach ($books as $book) {

                    if ($book->stock < 1) {
                        throw new \Exception(
                            "{$book->title} is unavailable"
                        );
                    }

                    $deposit =
                        $book->rental_price *
                        $depositRatio;

                    $totalAmount +=
                        $book->rental_price +
                        $deposit;
                }

                $bill = Bill::create([
                    'customer_id' => $customer->id,
                    'total_amount' => $totalAmount,
                    'payment_method' => $paymentMethod,
                    'status' => 'paid',
                ]);

                foreach ($books as $book) {

                    $deposit =
                        $book->rental_price *
                        $depositRatio;

                    BillItem::create([
                        'bill_id' => $bill->id,
                        'book_id' => $book->id,

                        'rental_price' => $book->rental_price,
                        'deposit_amount' => $deposit,

                        'fine_amount' => 0,
                        'added_amount' => 0,

                        'extension_count' => 0,

                        'due_at' => now()->addDays(
                            $borrowDays
                        ),

                        'status' => 'reserved',

                        'return_at' => null,
                        'customer_return_amount' => null,
                    ]);

                    $book->decrement('stock');
                }

                Payment::create([
                    'bill_id' => $bill->id,
                    'amount' => $totalAmount,
                    'method' => $paymentMethod,
                    'type' => 'payment',
                    'status' => 'complete',
                    'paid_at' => now(),
                ]);

                return $bill->load([
                    'items.book',
                    'payments'
                ]);
            });
        }
}