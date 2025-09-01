<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // In the migration file
public function up()
{
    Schema::create('expenses', function (Blueprint $table) {
        $table->id();
        $table->date('expense_date');
        $table->string('description');
        $table->enum('category', ['office_supplies', 'travel', 'meals', 'utilities', 'equipment', 'software', 'training', 'staff_payments', 'other']);
        $table->decimal('amount', 10, 2);
        $table->enum('payment_method', ['cash', 'credit_card', 'debit_card', 'bank_transfer', 'check']);
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->string('receipt_path')->nullable();
        $table->text('notes')->nullable();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
