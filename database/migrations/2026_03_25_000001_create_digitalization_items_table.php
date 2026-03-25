<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('digitalization_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->constrained('entities')->onDelete('cascade');
            $table->string('item_name'); // Nama item yang dimonitor
            $table->string('category'); // Kategori: Hardware, Software, Process, etc.
            $table->text('description')->nullable();
            $table->float('progress_actual')->default(0); // Progress aktual (0-100+)
            $table->float('progress_target')->default(100); // Target progress
            $table->enum('status', ['pending', 'in_progress', 'completed', 'delayed'])->default('pending');
            $table->date('start_date')->nullable();
            $table->date('target_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('assigned_to')->nullable(); // PIC yang bertanggung jawab
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('entity_id');
            $table->index('status');
            $table->index('category');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digitalization_items');
    }
};
