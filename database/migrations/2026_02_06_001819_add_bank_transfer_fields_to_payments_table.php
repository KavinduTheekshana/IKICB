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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('reference_number')->nullable()->after('transaction_id');
            $table->string('receipt_path')->nullable()->after('payment_details');
            $table->text('admin_notes')->nullable()->after('receipt_path');
            $table->foreignId('approved_by')->nullable()->after('admin_notes')->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['reference_number', 'receipt_path', 'admin_notes', 'approved_by', 'approved_at']);
        });
    }
};
