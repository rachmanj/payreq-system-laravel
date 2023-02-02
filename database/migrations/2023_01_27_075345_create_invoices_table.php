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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_invoice')->nullable();
            $table->integer('invoice_irr_id')->nullable();
            $table->string('vendor_name')->nullable();
            $table->date('received_date')->nullable(); // invoice diterima oleh Accounting invoicer
            $table->string('payment_date')->nullable();
            $table->double('amount')->nullable();
            $table->string('origin')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('invoices');
    }
};
