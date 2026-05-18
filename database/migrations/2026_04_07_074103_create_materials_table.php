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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            
            // Basic Fields
            $table->string('material_name');
            $table->string('supplier_name');
            $table->string('project_site')->nullable();
            $table->enum('discipline', ['Civil', 'MEP']);
            $table->enum('procurement_product', ['Material', 'Service']);
            $table->enum('supply_route', ['Import', 'Local']);
            $table->boolean('approval')->default(false);
            $table->enum('procurement_type', [
                'LVA', 'RFQ-Local', 'RFQ-Import-Birr', 'RFQ-Import-USD', 
                'IFB-ICB', 'IFB-NCB', 'RFP', 'LTA'
            ]);

            // Timeline Fields
            $table->date('design_planned')->nullable();
            $table->date('design_actual')->nullable();
            $table->date('specification_preparation')->nullable();
            $table->date('request_order')->nullable();
            $table->date('supplier_identification')->nullable();
            $table->date('material_submittal')->nullable();
            $table->date('material_approval')->nullable();
            $table->date('finance')->nullable();
            $table->date('lc')->nullable();
            $table->date('production_completion')->nullable();
            $table->integer('production_days')->nullable();
            $table->date('shipment_of_material')->nullable();
            $table->integer('shipment_days')->nullable();
            $table->date('logistics_to_dry_port')->nullable();
            $table->date('clearance_of_material')->nullable();
            $table->date('delivery_to_site')->nullable();
            $table->date('planned_start_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
