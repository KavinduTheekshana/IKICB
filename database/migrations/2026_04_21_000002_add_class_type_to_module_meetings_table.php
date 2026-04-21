<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('module_meetings', function (Blueprint $table) {
            $table->enum('class_type', ['online', 'physical'])->default('online')->after('meeting_type');
            $table->string('location')->nullable()->after('class_type');
            $table->string('meeting_link')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('module_meetings', function (Blueprint $table) {
            $table->dropColumn(['class_type', 'location']);
            $table->string('meeting_link')->nullable(false)->change();
        });
    }
};
