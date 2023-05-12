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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->string('type', 20)->nullable();
            $table->string('number_format')->nullable();
            $table->integer('number')->nullable();
            $table->string('code_number')->nullable();
            $table->string('currency', 20)->nullable();
            $table->date('date')->nullable();

            $table->foreignId('ledger_id')->nullable()->constrained('ledgers')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->decimal('amount', 25, 5)->default(0);

            $table->text('description')->nullable();

            $table->datetime('cancelled_at')->nullable();

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
        Schema::dropIfExists('transactions');
    }
};
