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
        Schema::create('giros', function (Blueprint $table) {
            $table->id();
            $table->string('nomor', 30)->unique();
            $table->string('bank', 50)->nullable();
            $table->string('account', 50)->nullable();
            $table->string('giro_type', 20)->nullable(); //cek or bilyet
            $table->date('tanggal')->nullable();
            $table->string('remarks')->nullable();
            $table->text('use_for')->nullable();
            $table->string('filename')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('giros');
    }
};
