<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('module_videos', function (Blueprint $table) {
            $table->string('temp_file_path')->nullable()->after('order');
        });
    }

    public function down(): void
    {
        Schema::table('module_videos', function (Blueprint $table) {
            $table->dropColumn('temp_file_path');
        });
    }
};
