<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('staff', function (Blueprint $table) {
            // Add gender column at the end (don't use after())
            if (!Schema::hasColumn('staff', 'gender')) {
                $table->string('gender')->nullable();
            }

            // Add contact column at the end (don't use after())
            if (!Schema::hasColumn('staff', 'contact')) {
                $table->string('contact')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('staff', function (Blueprint $table) {
            if (Schema::hasColumn('staff', 'contact')) {
                $table->dropColumn('contact');
            }
            if (Schema::hasColumn('staff', 'gender')) {
                $table->dropColumn('gender');
            }
        });
    }
};
