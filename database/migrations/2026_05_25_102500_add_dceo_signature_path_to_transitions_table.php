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
        Schema::table('transitions', function (Blueprint $table) {
            $table->string('dceo_signature_path')->nullable()->after('signature_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transitions', function (Blueprint $table) {
            $table->dropColumn('dceo_signature_path');
        });
    }
};
