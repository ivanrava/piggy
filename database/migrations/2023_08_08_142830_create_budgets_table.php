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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->decimal('jan', 10, 2);
            $table->decimal('feb', 10, 2);
            $table->decimal('mar', 10, 2);
            $table->decimal('apr', 10, 2);
            $table->decimal('may', 10, 2);
            $table->decimal('jun', 10, 2);
            $table->decimal('jul', 10, 2);
            $table->decimal('aug', 10, 2);
            $table->decimal('sep', 10, 2);
            $table->decimal('oct', 10, 2);
            $table->decimal('nov', 10, 2);
            $table->decimal('dec', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
