<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('products')) {
            // Table already exists, check if certification_id column exists
            if (!Schema::hasColumn('products', 'certification_id')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->unsignedBigInteger('certification_id')->nullable()->after('status');
                    $table->index('certification_id');
                });
            }
            // Foreign key will be added in certifications migration if certifications table exists
            return;
        }

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->enum('bike_type', ['road', 'mountain', 'gravel', 'hybrid', 'electric', 'bmx', 'cruiser', 'folding', 'touring', 'cyclocross']);
            $table->enum('frame_material', ['carbon', 'aluminum', 'steel', 'titanium', 'titanium_carbon']);
            $table->enum('brake_type', ['rim_brake', 'disc_brake_mechanical', 'disc_brake_hydraulic', 'coaster_brake']);
            $table->string('wheel_size');
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('weight_unit', 3)->default('kg');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->integer('year')->nullable();
            $table->enum('status', ['draft', 'pending', 'active', 'sold', 'inactive'])->default('draft');
            $table->unsignedBigInteger('certification_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('seller_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('set null');
            // certification_id foreign key will be added after certifications table is created
            $table->index('seller_id');
            $table->index('category_id');
            $table->index('status');
            $table->index('certification_id');
            $table->fullText(['title', 'description', 'brand', 'model']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
