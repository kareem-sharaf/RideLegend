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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('carrier');
            $table->enum('service_type', ['standard', 'express', 'overnight', 'economy'])->default('standard');
            $table->enum('status', ['pending', 'label_created', 'picked_up', 'in_transit', 'out_for_delivery', 'delivered', 'exception'])->default('pending');
            $table->string('tracking_number')->unique()->nullable();
            $table->decimal('cost', 10, 2)->default(0.00);
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->index('order_id');
            $table->index('tracking_number');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
