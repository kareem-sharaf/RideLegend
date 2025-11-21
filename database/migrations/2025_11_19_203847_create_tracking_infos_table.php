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
        Schema::create('tracking_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipping_id');
            $table->string('status');
            $table->string('location')->nullable();
            $table->timestamp('timestamp');
            $table->text('details')->nullable();
            $table->timestamps();

            $table->foreign('shipping_id')->references('id')->on('shippings')->onDelete('cascade');
            $table->index('shipping_id');
            $table->index('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_infos');
    }
};
