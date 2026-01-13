<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_user', function (Blueprint $table) {
            
            $table->id();
            
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('user_id');

            // Who shared it (optional)
            $table->unsignedBigInteger('shared_by')->nullable();

            // Permission type (optional: view, edit, etc)
            $table->string('permission')->default('view');

            $table->timestamps();

            // Foreign Keys
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shared_by')->references('id')->on('users')->nullOnDelete();

            // Prevent duplicates
            $table->unique(['document_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_user');
    }
};
