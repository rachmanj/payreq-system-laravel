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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('payreq_id')->nullable();
            $table->date('posting_date')->nullable();
            $table->string('description', 100)->nullable();
            $table->string('type', 20)->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('created_by', 50)->nullable();
            $table->string('deleted_by', 50)->nullable();
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
        Schema::dropIfExists('transaksis');
    }
};
