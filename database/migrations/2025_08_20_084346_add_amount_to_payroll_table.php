<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    if (!Schema::hasColumn('payroll', 'amount')) {
        Schema::table('payroll', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)->default(0);
        });
    }
}

public function down()
{
    if (Schema::hasColumn('payroll', 'amount')) {
        Schema::table('payroll', function (Blueprint $table) {
            $table->dropColumn('amount');
        });
    }
}
};
