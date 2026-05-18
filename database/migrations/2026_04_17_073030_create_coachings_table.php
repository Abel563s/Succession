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
        Schema::create('coachings', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_name');
            $table->string('supervisor');
            $table->string('department');
            $table->date('coaching_date');
            
            $table->text('topic_1')->nullable();
            $table->text('topic_2')->nullable();
            $table->text('topic_3')->nullable();
            
            $table->text('desired_outcome')->nullable();
            $table->text('benefits')->nullable();
            $table->text('action_plan')->nullable();
            $table->text('supervisor_support')->nullable();
            $table->text('timeline')->nullable();
            
            $table->string('manager_signature')->nullable();
            $table->string('candidate_signature')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coachings');
    }
};
