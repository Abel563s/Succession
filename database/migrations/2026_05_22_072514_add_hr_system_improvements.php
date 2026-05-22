<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var array<string, string>
     */
    protected array $hrTables = [
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

    public function up(): void
    {
        if (Schema::hasTable('users') && ! Schema::hasColumn('users', 'signature_path')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('signature_path')->nullable()->after('phone');
            });
        }

        if (Schema::hasTable('developments')) {
            Schema::table('developments', function (Blueprint $table) {
                if (! Schema::hasColumn('developments', 'candidate_signature_path')) {
                    $table->string('candidate_signature_path')->nullable()->after('signature_path');
                }
                if (! Schema::hasColumn('developments', 'created_by')) {
                    $table->foreignId('created_by')->nullable()->after('id')->constrained('users')->nullOnDelete();
                }
            });
        }

        if (Schema::hasTable('progress_reviews')) {
            Schema::table('progress_reviews', function (Blueprint $table) {
                if (! Schema::hasColumn('progress_reviews', 'development_id')) {
                    $table->foreignId('development_id')->nullable()->after('id')->constrained('developments')->nullOnDelete();
                    $table->unique('development_id');
                }
                if (! Schema::hasColumn('progress_reviews', 'created_by')) {
                    $table->foreignId('created_by')->nullable()->after('development_id')->constrained('users')->nullOnDelete();
                }
            });
        }

        foreach ($this->hrTables as $tableName) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (! Schema::hasColumn($tableName, 'created_by')) {
                    $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                }
            });
        }

        if (! Schema::hasTable('progress_idp_objectives')) {
            Schema::create('progress_idp_objectives', function (Blueprint $table) {
                $table->id();
                $table->foreignId('progress_review_id')->constrained()->cascadeOnDelete();
                $table->foreignId('idp_objective_id')->nullable()->constrained('idp_objectives')->nullOnDelete();
                $table->unsignedTinyInteger('row_number');
                $table->text('objective')->nullable();
                $table->text('activity')->nullable();
                $table->text('resource')->nullable();
                $table->date('start_date')->nullable();
                $table->date('delivery_date')->nullable();
                $table->text('expected_outcome')->nullable();
                $table->string('score')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('progress_idp_objectives');

        if (Schema::hasTable('progress_reviews')) {
            Schema::table('progress_reviews', function (Blueprint $table) {
                if (Schema::hasColumn('progress_reviews', 'development_id')) {
                    $table->dropUnique(['development_id']);
                    $table->dropConstrainedForeignId('development_id');
                }
                if (Schema::hasColumn('progress_reviews', 'created_by')) {
                    $table->dropConstrainedForeignId('created_by');
                }
            });
        }

        if (Schema::hasTable('developments')) {
            Schema::table('developments', function (Blueprint $table) {
                if (Schema::hasColumn('developments', 'candidate_signature_path')) {
                    $table->dropColumn('candidate_signature_path');
                }
                if (Schema::hasColumn('developments', 'created_by')) {
                    $table->dropConstrainedForeignId('created_by');
                }
            });
        }

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'signature_path')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('signature_path');
            });
        }

        foreach ($this->hrTables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'created_by')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropConstrainedForeignId('created_by');
                });
            }
        }
    }
};
