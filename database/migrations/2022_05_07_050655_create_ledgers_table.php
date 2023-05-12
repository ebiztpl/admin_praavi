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
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->string('name')->nullable();
            $table->string('alias')->nullable();
            $table->text('description')->nullable();

            $table->nullableMorphs('model');

            $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('cascade');
            $table->foreignId('ledger_type_id')->nullable()->constrained('ledger_types')->onDelete('set null');
            $table->foreignId('parent_id')->nullable()->constrained('ledgers')->onDelete('cascade');

            $table->decimal('opening_balance', 25, 5)->default(0);
            $table->decimal('current_balance', 25, 5)->default(0);
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
        Schema::dropIfExists('ledgers');
    }
};
