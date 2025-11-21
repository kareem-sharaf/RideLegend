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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 50)->unique();
            $table->unsignedBigInteger('buyer_id');
            $table->enum('status', ['draft', 'pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'])->default('draft');
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('shipping_cost', 10, 2)->default(0.00);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2)->default(0.00);
            $table->string('currency', 3)->default('USD');
            $table->timestamp('placed_at')->nullable();
            $table->timestamps();

            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('restrict');
            $table->index('buyer_id');
            $table->index('order_number');
            $table->index('status');
            $table->index('placed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
