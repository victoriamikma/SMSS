<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('staff_number')->unique();
            $table->string('position');
            $table->string('department');
            $table->date('date_of_employment');
            $table->string('phone');
            $table->string('email')->unique();
             $table->string('role');
    $table->string('gender');
    $table->string('contact');
    $table->decimal('salary', 12, 2);
    $table->string('bank_account');
    $table->string('bank_name');
    $table->string('nssf_number')->nullable();
    $table->string('tin_number')->nullable();
    $table->date('last_payment')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('staff');
    }
};