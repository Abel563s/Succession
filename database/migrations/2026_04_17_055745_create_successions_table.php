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
        Schema::create('successions', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_name');
            $table->string('department');
            $table->string('line_manager');
            $table->string('years_experience');
            $table->string('target_role');
            $table->text('core_competencies');
            $table->text('technical_competencies');
            $table->text('justification');
            $table->text('okr_achievement');
            $table->string('readiness_level');
            $table->string('ipg_score');
            $table->string('signature_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('successions');
    }
};
