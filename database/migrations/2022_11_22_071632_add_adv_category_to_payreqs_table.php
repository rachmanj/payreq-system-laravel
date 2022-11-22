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
        Schema::table('payreqs', function (Blueprint $table) {
            $table->integer('advance_category_id')->after('payreq_idr')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payreqs', function (Blueprint $table) {
            $table->dropColumn('adv_category_code');
        });
    }
};
