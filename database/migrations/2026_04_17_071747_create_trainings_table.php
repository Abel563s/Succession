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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_name');
            $table->string('department');
            $table->string('line_manager');
            
            $table->text('goal_1')->nullable();
            $table->string('skill_area_1')->nullable();
            $table->string('score_1')->nullable();
            
            $table->text('goal_2')->nullable();
            $table->string('skill_area_2')->nullable();
            $table->string('score_2')->nullable();
            
            $table->text('goal_3')->nullable();
            $table->string('skill_area_3')->nullable();
            $table->string('score_3')->nullable();
            
            $table->text('activities')->nullable();
            $table->text('expected_outcomes')->nullable();
            $table->text('feedback')->nullable();
            $table->string('signature_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
