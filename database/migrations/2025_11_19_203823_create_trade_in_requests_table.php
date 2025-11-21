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
        Schema::create('trade_in_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trade_in_id');
            $table->string('brand');
            $table->string('model');
            $table->integer('year')->nullable();
            $table->enum('condition', ['excellent', 'good', 'fair', 'poor'])->default('good');
            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->json('specifications')->nullable();
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
        Schema::dropIfExists('trade_in_requests');
    }
};
