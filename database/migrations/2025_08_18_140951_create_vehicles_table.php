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
    Schema::create('vehicles', function (Blueprint $table) {
        $table->id(); // This creates an unsignedBigInteger primary key
        $table->string('name');
        $table->string('type'); // bus, van, etc.
        $table->string('license_plate')->unique();
        $table->integer('capacity');
        $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
