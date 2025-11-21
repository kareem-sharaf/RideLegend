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
        Schema::create('valuations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trade_in_id');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('strategy_used')->nullable();
            $table->json('calculation_details')->nullable();
            $table->timestamp('calculated_at')->nullable();
            $table->timestamps();

            $table->foreign('trade_in_id')->references('id')->on('trade_ins')->onDelete('cascade');
            $table->index('trade_in_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valuations');
    }
};
