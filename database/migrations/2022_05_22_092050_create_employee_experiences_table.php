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
        Schema::create('employee_experiences', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->string('headline')->nullable();
            $table->string('title')->nullable();
            $table->string('company_name', 50)->nullable();
            $table->string('location')->nullable();

            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade');
            $table->foreignId('employment_type_id')->nullable()->constrained('options')->onDelete('cascade');

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->text('job_profile')->nullable();
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
        Schema::dropIfExists('employee_experiences');
    }
};
