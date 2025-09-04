<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStudentIdToLibraryTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('library_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id')->nullable()->after('book_id');

            // Optional: Add foreign key constraint
            $table->foreign('student_id')->references('id')->on('students')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('library_transactions', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropColumn('student_id');
        });
    }
}
