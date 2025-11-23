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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('set null');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->unsignedBigInteger('amount_cents')->default(0);
            $table->enum('type', ['income', 'expense', 'transfer']);
            $table->char('currency', 3)->default('INR');
            $table->decimal('exchange_rate', 18, 8)->nullable();
            $table->date('date');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'cleared', 'reconciled'])->default('cleared');
            $table->boolean('is_recurring')->default(false);
            $table->unsignedBigInteger('recurring_id')->nullable();
            $table->json('meta')->nullable();

            $table->timestamps();
            $table->softDeletes();
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
