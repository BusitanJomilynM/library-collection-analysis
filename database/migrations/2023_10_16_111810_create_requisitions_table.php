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
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('book_title');
            $table->integer('copies');
            $table->string('material_type');
            $table->string('author');
            $table->string('isbn');
            $table->string('publisher');
            $table->string('edition');
            $table->string('source')->nullable();
            $table->integer('user_id');
            $table->string('type');
            $table->string('department');
            $table->integer('status');
            $table->binary('disapproval_reason')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisitions');
    }
};
