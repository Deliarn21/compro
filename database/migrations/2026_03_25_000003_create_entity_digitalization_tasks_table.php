<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entity_digitalization_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->constrained('entities')->onDelete('cascade');
            $table->foreignId('digitalization_task_id')->constrained('digitalization_tasks')->onDelete('cascade');
            $table->decimal('progress_actual', 5, 2)->default(0);
            $table->decimal('progress_target', 5, 2)->default(100);
            $table->enum('status', ['pending', 'in_progress', 'completed', 'delayed'])->default('pending');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('target_date')->nullable();
            $table->dateTime('completion_date')->nullable();
            $table->string('assigned_to')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['entity_id', 'digitalization_task_id']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entity_digitalization_tasks');
    }
};
