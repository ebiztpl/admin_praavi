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
        Schema::create('employee_qualifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->string('course')->nullable();
            $table->string('type', 50)->nullable();
            $table->string('institute')->nullable();

            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade');
            $table->foreignId('level_id')->nullable()->constrained('options')->onDelete('cascade');

            $table->string('affiliated_to')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('result')->nullable();
            $table->dateTime('verified_at')->nullable();

            $table->json('meta')->nullable();
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
        Schema::dropIfExists('employee_qualifications');
    }
};
