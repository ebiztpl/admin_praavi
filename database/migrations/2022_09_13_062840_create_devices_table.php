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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();

            $table->string('name')->nullable();
            $table->string('type', 50)->nullable();

            $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('cascade');

            $table->string('code')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('token')->nullable();
            $table->text('description')->nullable();

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
        Schema::dropIfExists('devices');
    }
};
