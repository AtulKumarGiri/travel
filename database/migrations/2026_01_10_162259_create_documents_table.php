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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('title')->nullable();
            $table->longText('body')->nullable();
            $table->string('type')->nullable(); // note, task, report, etc.
            $table->boolean('is_private')->default(false);
            $table->json('shared_with')->nullable(); // user IDs
            $table->string('status')->default('active'); // active, archived, deleted
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
