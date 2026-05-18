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
        Schema::create('succession_dashboard_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('succession_dashboard_id')->constrained()->onDelete('cascade');
            $table->string('position');
            $table->string('current_holder');
            $table->string('candidates');
            $table->text('timeline_progress')->nullable();
            $table->text('competency_progress')->nullable();
            $table->text('development_progress')->nullable();
            $table->text('kpi_metrics')->nullable();
            $table->text('monitoring_progress')->nullable();
            $table->string('readiness_rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('succession_dashboard_items');
    }
};
