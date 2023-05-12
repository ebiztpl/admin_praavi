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
        Schema::create('salary_template_records', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();

            $table->foreignId('salary_template_id')->nullable()->constrained('salary_templates')->onDelete('cascade');
            $table->foreignId('pay_head_id')->nullable()->constrained('pay_heads')->onDelete('cascade');
            $table->foreignId('attendance_type_id')->nullable()->constrained('attendance_types')->onDelete('cascade');

            $table->string('category', 20)->nullable();
            $table->integer('position')->default(0);
            $table->string('computation')->nullable();

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
        Schema::dropIfExists('salary_template_records');
    }
};
