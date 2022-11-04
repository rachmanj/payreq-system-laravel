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
            $table->boolean('budgeted')->default(true)->after('approve_date');
            $table->integer('over_due')->after('que_group')->nullable();
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
            //
        });
    }
};
