<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'manager', 'user', 'department_attendance_user', 'dceo') DEFAULT 'user'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverting this might drop 'dceo' users or cause errors, but for completeness:
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'manager', 'user', 'department_attendance_user') DEFAULT 'user'");
    }
};
