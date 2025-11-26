<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('inspection_id');
            $table->unsignedBigInteger('workshop_id');
            $table->enum('grade', ['A+', 'A', 'B', 'C']);
            $table->string('report_url');
            $table->enum('status', ['active', 'expired', 'revoked'])->default('active');
            $table->timestamp('issued_at');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('inspection_id')->references('id')->on('inspections')->onDelete('restrict');
            $table->foreign('workshop_id')->references('id')->on('users')->onDelete('restrict');
            $table->unique('product_id');
            $table->index('status');
            $table->index('expires_at');
        });
        
        // Add foreign key constraint from products to certifications if it doesn't exist
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'certification_id')) {
            try {
                Schema::table('products', function (Blueprint $table) {
                    $table->foreign('certification_id')->references('id')->on('certifications')->onDelete('set null');
                });
            } catch (\Exception $e) {
                // Foreign key might already exist, ignore
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};

