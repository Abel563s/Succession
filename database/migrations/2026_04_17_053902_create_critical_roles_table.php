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
        Schema::create('critical_roles', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name');
            $table->string('department');
            $table->string('critical_role');
            $table->string('position_status');
            $table->string('vacancy_risk');
            $table->string('position_impact');
            
            $table->string('successor_1_name')->nullable();
            $table->string('successor_1_readiness')->nullable();
            
            $table->string('successor_2_name')->nullable();
            $table->string('successor_2_readiness')->nullable();
            
            $table->string('successor_3_name')->nullable();
            $table->string('successor_3_readiness')->nullable();
            
            $table->text('mitigation_plan');
            $table->string('signature_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('critical_roles');
    }
};
