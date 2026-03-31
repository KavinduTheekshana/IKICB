<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('bunny_library_id');
            $table->string('bunny_video_id')->nullable();
            $table->string('video_url')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->enum('status', ['uploading', 'processing', 'ready', 'failed'])->default('uploading');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_videos');
    }
};
