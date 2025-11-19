<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('workshop_id');
            $table->enum('status', ['pending', 'scheduled', 'in_progress', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->enum('frame_grade', ['excellent', 'very_good', 'good', 'fair', 'poor'])->nullable();
            $table->text('frame_notes')->nullable();
            $table->enum('brake_grade', ['excellent', 'very_good', 'good', 'fair', 'poor'])->nullable();
            $table->text('brake_notes')->nullable();
            $table->enum('groupset_grade', ['excellent', 'very_good', 'good', 'fair', 'poor'])->nullable();
            $table->text('groupset_notes')->nullable();
            $table->enum('wheels_grade', ['excellent', 'very_good', 'good', 'fair', 'poor'])->nullable();
            $table->text('wheels_notes')->nullable();
            $table->enum('overall_grade', ['A+', 'A', 'B', 'C'])->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('workshop_id')->references('id')->on('users')->onDelete('restrict');
            $table->index('product_id');
            $table->index('workshop_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};

