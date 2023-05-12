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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();

            $table->string('first_name', 50)->nullable();
            $table->string('middle_name', 50)->nullable();
            $table->string('third_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();

            $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->date('birth_date')->nullable();
            $table->date('anniversary_date')->nullable();
            $table->string('birth_place', 50)->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('contact_number', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('nationality', 100)->nullable();
            $table->string('mother_tongue', 50)->nullable();
            $table->string('photo')->nullable();
            $table->string('unique_id_number1', 50)->nullable();
            $table->string('unique_id_number2', 50)->nullable();
            $table->string('unique_id_number3', 50)->nullable();
            $table->json('alternate_records')->nullable();
            $table->json('address')->nullable();
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
        Schema::dropIfExists('contacts');
    }
};
