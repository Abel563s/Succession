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
        $tables = [
            'critical_roles',
            'successions',
            'nine_box_grids',
            'developments',
            'trainings',
            'coachings',
            'mentors',
            'progress_reviews',
            'succession_dashboards',
            'leadership_assessments',
            'transitions',
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    if (! Schema::hasColumn($tableName, 'approval_status')) {
                        $table->string('approval_status')->default('Pending');
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'critical_roles',
            'successions',
            'nine_box_grids',
            'developments',
            'trainings',
            'coachings',
            'mentors',
            'progress_reviews',
            'succession_dashboards',
            'leadership_assessments',
            'transitions',
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    if (Schema::hasColumn($tableName, 'approval_status')) {
                        $table->dropColumn('approval_status');
                    }
                });
            }
        }
    }
};
