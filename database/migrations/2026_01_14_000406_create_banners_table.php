<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('image');             // path to the banner image
            $table->string('heading');           // slide heading
            $table->text('subheading')->nullable(); // optional description
            $table->enum('status', ['draft','active'])->default('draft');
            $table->timestamps();                // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
