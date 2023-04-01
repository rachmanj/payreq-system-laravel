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
        Schema::create('general_rabs', function (Blueprint $table) {
            $table->id();
            $table->string('rab_no', 30); // nomor rab created by system
            $table->text('description')->nullable();
            $table->string('filename', 100)->nullable();
            $table->string('project_code', 10)->nullable();
            $table->foreignId('department_id')->nullable();
            $table->double('amount', 20, 2)->default(0);
            $table->date('rab_date')->nullable();
            $table->timestamp('submit_date')->nullable();
            $table->timestamp('approval_date')->nullable();
            $table->string('status', 10)->default('draft'); // 0 = draft, 1 = wait approve, 2 = approved, 3 = reject
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approval_by')->nullable(); // user yang approve / reject
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
        Schema::dropIfExists('general_rabs');
    }
};
