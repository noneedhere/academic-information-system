<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Add indexes on columns frequently used in WHERE clauses and filters
     * to improve query performance as data grows.
     */
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->index('teacher_id');
            $table->index('date');
            $table->index('status');
        });

        Schema::table('bills', function (Blueprint $table) {
            $table->index('status');
            $table->index('due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex(['teacher_id']);
            $table->dropIndex(['date']);
            $table->dropIndex(['status']);
        });

        Schema::table('bills', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['due_date']);
        });
    }
};
