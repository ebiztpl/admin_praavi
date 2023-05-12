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
        Schema::create('leave_request_records', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();

            $table->foreignId('leave_request_id')->nullable()->constrained('leave_requests')->onDelete('cascade');
            $table->foreignId('approve_user_id')->nullable()->constrained('users')->onDelete('cascade');

            $table->string('status', 20)->nullable();
            $table->text('comment')->nullable();

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
        Schema::dropIfExists('leave_request_records');
    }
};
