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
    Schema::create('subject_class', function (Blueprint $table) {
        $table->id();
        $table->foreignId('subject_id')->constrained()->onDelete('cascade');
        $table->foreignId('class_id')->constrained()->onDelete('cascade');
        $table->timestamps();

        $table->unique(['subject_id', 'class_id']);
    });
}

public function down()
{
    Schema::dropIfExists('subject_class');
}
};
