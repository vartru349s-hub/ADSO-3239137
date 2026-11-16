<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('document_number', 30)->nullable()->unique();
            $table->string('username', 120)->nullable()->unique();
            $table->string('role', 20)->default('customer');
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 80)->unique();
            $table->timestamps();
        });
        Schema::create('bicycles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('model_code', 40)->unique();
            $table->string('name', 160);
            $table->foreignUuid('category_id')->constrained();
            $table->decimal('hourly_rate', 10, 2);
            $table->unsignedInteger('total_units');
            $table->unsignedInteger('available_units');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('rentals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('operator_id')->constrained('users');
            $table->timestamp('rented_at');
            $table->timestamps();
        });
        Schema::create('rental_lines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('rental_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('bicycle_id')->constrained();
            $table->string('model_code', 40);
            $table->string('bicycle_name', 160);
            $table->string('category_name', 80);
            $table->decimal('hourly_rate', 10, 2);
            $table->timestamp('due_at');
            $table->timestamp('returned_at')->nullable();
            $table->timestamps();
            $table->index(['bicycle_id', 'returned_at']);
            $table->index(['due_at', 'returned_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_lines');
        Schema::dropIfExists('rentals');
        Schema::dropIfExists('bicycles');
        Schema::dropIfExists('categories');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['document_number', 'username', 'role']);
        });
    }
};
