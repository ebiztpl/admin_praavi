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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->string('number_format')->nullable();
            $table->integer('number')->nullable();
            $table->string('code_number')->nullable();

            $table->foreignId('contact_id')->nullable()->constrained('contacts')->onDelete('cascade');

            $table->date('joining_date')->nullable();
            $table->date('leaving_date')->nullable();

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
        Schema::dropIfExists('employees');
    }
};
