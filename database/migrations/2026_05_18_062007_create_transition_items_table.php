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
        Schema::create('transition_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transition_id')->constrained()->cascadeOnDelete();
            $table->integer('row_number')->default(1);
            $table->string('critical_role')->nullable();
            $table->string('current_holder')->nullable();
            $table->string('successor')->nullable();
            $table->date('transition_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transition_items');
    }
};
