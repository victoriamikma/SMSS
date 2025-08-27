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
       Schema::create('payroll', function (Blueprint $table) {
    $table->id();
    $table->foreignId('staff_id')->constrained();
    $table->string('period');
    $table->decimal('basic_salary', 12, 2);
    $table->decimal('allowances', 12, 2);
    $table->decimal('deductions', 12, 2);
    $table->decimal('net_pay', 12, 2);
    $table->date('payment_date');
    $table->string('status')->default('Paid');
    $table->string('payment_method');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll');
    }
};
