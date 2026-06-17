<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
             $table->id();

    $table->foreignId('cart_id')
        ->constrained('carts')
        ->onDelete('cascade');

    $table->foreignId('book_id')
        ->constrained('books')
        ->onDelete('cascade');

    $table->decimal('rental_price', 10, 2);

    $table->decimal('deposit', 10, 2);

    $table->unique(['cart_id', 'book_id']);// can't borrow 2 copies at ones  <3 مالي متاكدة عملتها هيك حالياً 

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
