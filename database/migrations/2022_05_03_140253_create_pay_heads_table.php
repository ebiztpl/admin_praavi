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
        Schema::create('pay_heads', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();

            $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('cascade');

            $table->string('name', 100)->nullable();
            $table->string('code', 20)->nullable();
            $table->string('alias', 20)->nullable();
            $table->string('type', 50)->nullable();
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
        Schema::dropIfExists('pay_heads');
    }
};
