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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id');
            $table->foreignId('category_id');
            $table->foreignId('beneficiary_id');
            $table->date('date');
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['out', 'in']);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('beneficiary_id')->references('id')->on('beneficiaries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
