<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    if (!Schema::hasColumn('events', 'is_public')) {
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('is_public')->default(true)->after('description');
        });
    }
}

public function down()
{
    if (Schema::hasColumn('events', 'is_public')) {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('is_public');
        });
    }
}
};