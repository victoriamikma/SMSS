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
    Schema::create('transports', function (Blueprint $table) {
        $table->id();
        $table->string('route');
        $table->unsignedBigInteger('vehicle_id'); // No foreign key here
        $table->unsignedBigInteger('driver_id');
        $table->string('schedule');
        $table->enum('status', ['active', 'inactive'])->default('active');
        $table->text('notes')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transports', function (Blueprint $table) {
        $table->dropForeign(['vehicle_id']);
        $table->dropForeign(['driver_id']);
    });
        Schema::dropIfExists('transports');
    }
};
