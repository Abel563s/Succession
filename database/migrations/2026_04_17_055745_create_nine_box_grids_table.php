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
        Schema::create('nine_box_grids', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_name');
            $table->string('department');
            $table->string('grid_position');
            $table->string('potential_level');
            $table->string('performance_level');
            $table->text('general_comments')->nullable();
            $table->text('strengths')->nullable();
            $table->text('development_needs')->nullable();
            $table->string('signature_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nine_box_grids');
    }
};
