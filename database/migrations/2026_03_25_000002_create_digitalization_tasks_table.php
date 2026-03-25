<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('digitalization_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_name');
            $table->string('category')->index();
            $table->text('description')->nullable();
            $table->string('estimated_duration')->nullable(); // e.g., "3 months"
            $table->enum('difficulty_level', ['easy', 'medium', 'hard'])->default('medium');
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('digitalization_tasks');
    }
};
