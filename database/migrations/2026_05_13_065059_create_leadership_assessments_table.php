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
        Schema::create('leadership_assessments', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_name');
            $table->string('department');
            $table->string('line_manager');
            $table->text('comments')->nullable();
            $table->string('signature_path')->nullable();
            $table->decimal('overall_score', 5, 2)->default(0);
            $table->string('status')->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leadership_assessments');
    }
};
