<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if users table exists, if so alter it, otherwise create it
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // Add columns if they don't exist
                if (!Schema::hasColumn('users', 'role')) {
                    $table->enum('role', ['buyer', 'seller', 'workshop', 'admin'])->default('buyer')->after('password');
                }
                if (!Schema::hasColumn('users', 'first_name')) {
                    $table->string('first_name')->nullable()->after('role');
                }
                if (!Schema::hasColumn('users', 'last_name')) {
                    $table->string('last_name')->nullable()->after('first_name');
                }
                if (!Schema::hasColumn('users', 'phone')) {
                    $table->string('phone')->nullable()->after('last_name');
                }
                if (!Schema::hasColumn('users', 'avatar')) {
                    $table->string('avatar')->nullable()->after('phone');
                }
                if (!Schema::hasColumn('users', 'deleted_at')) {
                    $table->softDeletes();
                }
            });

            // Note: email index already exists from unique constraint
            // Role index will be added after role column is created if it doesn't exist
            if (Schema::hasColumn('users', 'role')) {
                try {
                    Schema::table('users', function (Blueprint $table) {
                        $table->index('role');
                    });
                } catch (\Exception $e) {
                    // Index might already exist, ignore
                }
            }
        } else {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->enum('role', ['buyer', 'seller', 'workshop', 'admin'])->default('buyer');
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('phone')->nullable();
                $table->string('avatar')->nullable();
                $table->rememberToken();
                $table->timestamps();
                $table->softDeletes();

                $table->index('email');
                $table->index('role');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
