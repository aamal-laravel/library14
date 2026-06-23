<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bill_items', function (Blueprint $table) {

            $table->decimal('added_amount', 10, 2)
                ->default(0)
                ->after('deposit_amount');

            $table->unsignedInteger('extension_count')
                ->default(0)
                ->after('added_amount');

            $table->timestamp('due_at')
                ->nullable()
                ->after('extension_count');

            $table->enum('status', [
                'reserved',
                'received',
                'returned',
                'expired'
            ])->default('reserved')
              ->after('due_at');

            $table->timestamp('return_at')
                ->nullable()
                ->after('status');

            $table->decimal('customer_return_amount', 10, 2)
                ->nullable()
                ->after('return_at');
        });
    }

    public function down(): void
    {
        Schema::table('bill_items', function (Blueprint $table) {

            $table->dropColumn([
                'added_amount',
                'extension_count',
                'due_at',
                'status',
                'return_at',
                'customer_return_amount'
            ]);
        });
    }
};