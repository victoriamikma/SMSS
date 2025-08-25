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
    Schema::create('exams', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->unsignedBigInteger('subject_id'); // Use unsignedBigInteger first
        $table->unsignedBigInteger('class_id');
        $table->date('date');
        $table->time('start_time');
        $table->time('end_time');
        $table->text('description')->nullable();
        $table->timestamps();
    });

    // Add foreign key constraints separately
    if (Schema::hasTable('subjects') && Schema::hasTable('class_groups')) {
        Schema::table('exams', function (Blueprint $table) {
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('class_id')->references('id')->on('class_groups');
        });
    }
}

public function down()
{
    Schema::table('exams', function (Blueprint $table) {
        $table->dropForeign(['subject_id']);
        $table->dropForeign(['class_id']);
    });
    
    Schema::dropIfExists('exams');

    }
};
