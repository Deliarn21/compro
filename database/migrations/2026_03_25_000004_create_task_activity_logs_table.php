<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->constrained('entities')->onDelete('cascade');
            $table->foreignId('digitalization_task_id')->constrained('digitalization_tasks')->onDelete('cascade');
            $table->decimal('progress_before', 5, 2)->nullable();
            $table->decimal('progress_after', 5, 2)->nullable();
            $table->string('status_before')->nullable();
            $table->string('status_after')->nullable();
            $table->text('notes')->nullable();
            $table->string('proof_file')->nullable();
            $table->string('proof_file_original')->nullable();
            $table->string('activity_type'); // 'progress_update', 'status_change', 'proof_upload', 'task_added', 'task_removed'
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_activity_logs');
    }
};
