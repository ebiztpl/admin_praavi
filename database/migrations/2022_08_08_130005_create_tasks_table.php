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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->string('number_format')->nullable();
            $table->integer('number')->nullable();
            $table->string('code_number')->nullable();
            $table->string('title')->nullable();

            $table->nullableMorphs('taskable');

            $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('cascade');
            $table->foreignId('task_category_id')->nullable()->constrained('options')->onDelete('set null');
            $table->foreignId('task_priority_id')->nullable()->constrained('options')->onDelete('set null');
            $table->foreignId('task_list_id')->nullable()->constrained('options')->onDelete('set null');

            $table->integer('position')->default(0);
            $table->float('progress')->default(0);
            $table->string('status', 20)->nullable();
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->time('due_time')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->dateTime('archived_at')->nullable();
            $table->boolean('should_repeat')->default(0);

            $table->longText('description')->nullable();

            $table->json('repeatation')->nullable();
            $table->json('config')->nullable();
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
        Schema::dropIfExists('tasks');
    }
};
