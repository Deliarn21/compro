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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50)->index();
            $table->string('category', 50)->nullable()->index();
            $table->foreignId('parent_id')->nullable()->constrained('contents')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->nullable()->unique();
            $table->string('subtitle')->nullable();
            $table->text('summary')->nullable();
            $table->longText('body')->nullable();
            $table->string('image_path')->nullable();
            $table->string('link_url')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('legacy_path')->nullable()->unique();
            $table->json('extra')->nullable();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_published')->default(true)->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
