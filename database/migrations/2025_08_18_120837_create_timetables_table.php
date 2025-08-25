<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */public function up(): void
{
    Schema::create('timetables', function (Blueprint $table) {
        $table->id();
        $table->string('day_of_week');
        $table->time('start_time');
        $table->time('end_time');
        $table->unsignedBigInteger('class_id');
        $table->unsignedBigInteger('subject_id');
        $table->unsignedBigInteger('teacher_id');
        $table->string('room');
        $table->timestamps();
    });

    // Add this check before creating foreign keys
    if (Schema::hasTable('class_groups') && 
        Schema::hasTable('subjects') && 
        Schema::hasTable('users')) {
        
        Schema::table('timetables', function (Blueprint $table) {
            $table->foreign('class_id')->references('id')->on('class_groups');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('teacher_id')->references('id')->on('users');
        });
    }
}

public function down(): void
{
    Schema::table('timetables', function (Blueprint $table) {
        $table->dropForeign(['class_id']);
        $table->dropForeign(['subject_id']);
        $table->dropForeign(['teacher_id']);
    });
    
    Schema::dropIfExists('timetables');
}
    
};
