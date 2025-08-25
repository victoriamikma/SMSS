<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('staff', function (Blueprint $table) {
            // Remove columns that are not in the Staff model
            if (Schema::hasColumn('staff', 'staff_number')) {
                $table->dropColumn('staff_number');
            }
            if (Schema::hasColumn('staff', 'position')) {
                $table->dropColumn('position');
            }
            if (Schema::hasColumn('staff', 'department')) {
                $table->dropColumn('department');
            }
            if (Schema::hasColumn('staff', 'date_of_employment')) {
                $table->dropColumn('date_of_employment');
            }
            if (Schema::hasColumn('staff', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('staff', 'email')) {
                $table->dropColumn('email');
            }
            
            // Add missing columns that are in the Staff model
            if (!Schema::hasColumn('staff', 'contact')) {
                $table->string('contact')->after('gender');
            }
            if (!Schema::hasColumn('staff', 'salary')) {
                $table->decimal('salary', 12, 2)->after('contact');
            }
            if (!Schema::hasColumn('staff', 'bank_account')) {
                $table->string('bank_account')->after('salary');
            }
            if (!Schema::hasColumn('staff', 'bank_name')) {
                $table->string('bank_name')->after('bank_account');
            }
            if (!Schema::hasColumn('staff', 'nssf_number')) {
                $table->string('nssf_number')->nullable()->after('bank_name');
            }
            if (!Schema::hasColumn('staff', 'tin_number')) {
                $table->string('tin_number')->nullable()->after('nssf_number');
            }
            if (!Schema::hasColumn('staff', 'last_payment')) {
                $table->date('last_payment')->nullable()->after('tin_number');
            }
        });
    }

    public function down()
    {
        // This is a structural change, so the down method would be complex
        // In practice, you might want to create a backup before running this
    }
};