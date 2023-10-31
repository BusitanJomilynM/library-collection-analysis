<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('book_title');
            $table->string('book_callnumber');
            $table->string('book_barcode')->unique();
            $table->string('book_copynumber');
            $table->string('book_author');
            $table->integer('book_copyrightyear');
            $table->string('book_sublocation');
            $table->string('book_subject');
            $table->string('book_publisher');
            $table->string('book_lccn');
            $table->string('book_isbn');
            $table->string('book_edition')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
