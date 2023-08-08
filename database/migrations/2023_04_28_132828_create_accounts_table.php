<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TOTAL_DIGITS = 10;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('account_type_id')->constrained()->cascadeOnDelete();
            $table->decimal('initial_balance', self::TOTAL_DIGITS, 2);
            $table->string('name');
            $table->string('icon');
            $table->string('color', 6);
            $table->date('opening');
            $table->date('closing')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
