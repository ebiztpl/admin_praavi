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
        Schema::create('salary_structure_records', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();

            $table->foreignId('salary_structure_id')->nullable()->constrained('salary_structures')->onDelete('cascade');
            $table->foreignId('pay_head_id')->nullable()->constrained('pay_heads')->onDelete('cascade');

            $table->decimal('amount', 25, 5)->default(0);
            $table->string('unit', 20)->nullable();

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
        Schema::dropIfExists('salary_structure_records');
    }
};
