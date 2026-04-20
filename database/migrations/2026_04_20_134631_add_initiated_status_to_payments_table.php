<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('initiated','pending','completed','failed','refunded') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("UPDATE payments SET status = 'failed' WHERE status = 'initiated'");
        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('pending','completed','failed','refunded') NOT NULL DEFAULT 'pending'");
    }
};
