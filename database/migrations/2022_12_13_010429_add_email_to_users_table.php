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
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->after('username')->nullable();
            $table->timestamp('last_notif')->after('is_active')->nullable(); // email notification last sent
            $table->string('notif_flag', 10)->after('last_notif')->nullable(); // email notification flag
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('last_notif');
            $table->dropColumn('notif_flag');
        });
    }
};
