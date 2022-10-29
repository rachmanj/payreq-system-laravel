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
        Schema::create('payreqs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('payreq_num')->nullable();
            $table->string('payreq_type')->nullable();
            $table->double('payreq_idr')->nullable();
            $table->date('approve_date')->nullable();
            $table->integer('que_group')->nullable();
            $table->date('outgoing_date')->nullable();
            $table->string('realization_num')->nullable();
            $table->date('realization_date')->nullable();
            $table->double('realization_amount')->nullable();
            $table->date('verify_date')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('rab_id')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('payreqs');
    }
};
