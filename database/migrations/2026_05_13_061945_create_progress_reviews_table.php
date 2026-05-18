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
        Schema::create('progress_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_name');
            $table->string('department');
            $table->string('line_manager');
            $table->text('performance_summary')->nullable(); // Progress on IDP, Coaching & Training
            $table->text('new_competencies')->nullable();
            $table->text('gaps_identified')->nullable();
            $table->text('updated_action_plan')->nullable();
            $table->string('signature_path')->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_reviews');
    }
};
