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
        Schema::create('shipping_labels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipping_id');
            $table->string('label_url')->nullable();
            $table->json('label_data')->nullable();
            $table->timestamps();

            $table->foreign('shipping_id')->references('id')->on('shippings')->onDelete('cascade');
            $table->index('shipping_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_labels');
    }
};
