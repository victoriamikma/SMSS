<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('admission_number')->unique();
            $table->foreignId('class_id')->constrained();
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('parent_name');
            $table->string('parent_phone');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};