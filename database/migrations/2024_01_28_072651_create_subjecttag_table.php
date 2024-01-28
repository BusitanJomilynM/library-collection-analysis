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
        Schema::create('subjecttag', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('book_barcode');
            $table->string('department');
            $table->string('suggest_book_subject');
            $table->integer('user_id');
            $table->integer('action');
            $table->integer('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjecttag');
    }
};
