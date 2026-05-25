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
            'successions',
            'nine_box_grids',
            'mentors',
            'succession_dashboards',
            'leadership_assessments',
            'transitions'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'created_by')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->unsignedBigInteger('created_by')->nullable()->after('id');
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
            'successions',
            'nine_box_grids',
            'mentors',
            'succession_dashboards',
            'leadership_assessments',
            'transitions'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'created_by')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('created_by');
                });
            }
        }
    }
};
