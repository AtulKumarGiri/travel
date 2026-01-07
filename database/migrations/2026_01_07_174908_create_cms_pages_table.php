<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cms_pages', function (Blueprint $table) {
            $table->id();

            // Core
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->string('image')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            // Publishing
            $table->enum('status', ['draft','active','inactive'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            // Access
            $table->enum('visibility',['public','private','role'])->default('public');
            $table->json('allowed_roles')->nullable();

            // Navigation
            $table->foreignId('parent_id')->nullable()->constrained('cms_pages')->nullOnDelete();
            $table->integer('menu_order')->default(0);
            $table->boolean('show_in_menu')->default(true);

            // Template
            $table->string('template')->default('default');

            // Audit
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_pages');
    }
};
