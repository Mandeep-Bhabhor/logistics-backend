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
        Schema::table('warehouses', function (Blueprint $table) {
            // Add manager_id column referencing users table
            $table->foreignId('manager_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->after('capacity');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warehouses', function (Blueprint $table) {
            // Drop foreign key and column on rollback
            $table->dropForeign(['manager_id']);
            $table->dropColumn('manager_id');
        });
    }
};
