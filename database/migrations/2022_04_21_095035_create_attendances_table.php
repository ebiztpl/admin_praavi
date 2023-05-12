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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();

            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade');
            $table->foreignId('attendance_type_id')->nullable()->constrained('attendance_types')->onDelete('cascade');
            $table->string('attendance_symbol', 10)->nullable();

            $table->date('date')->nullable();
            $table->boolean('is_time_based')->default(0);
            $table->text('remarks')->nullable();

            $table->json('meta')->nullable();
            $table->timestamps();

            $table->unique(['date', 'employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};
