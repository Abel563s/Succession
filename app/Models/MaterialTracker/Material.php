<?php

namespace App\Models\MaterialTracker;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'material_name',
        'supplier_name',
        'project_site',
        'discipline',
        'procurement_product',
        'supply_route',
        'approval',
        'procurement_type',
        'design_planned',
        'design_actual',
        'specification_preparation',
        'request_order',
        'supplier_identification',
        'material_submittal',
        'material_approval',
        'finance',
        'lc',
        'production_completion',
        'production_days',
        'shipment_of_material',
        'shipment_days',
        'logistics_to_dry_port',
        'clearance_of_material',
        'delivery_to_site',
        'planned_start_date',
    ];

    protected $casts = [
        'approval' => 'boolean',
        'design_planned' => 'date',
        'design_actual' => 'date',
        'specification_preparation' => 'date',
        'request_order' => 'date',
        'supplier_identification' => 'date',
        'material_submittal' => 'date',
        'material_approval' => 'date',
        'finance' => 'date',
        'lc' => 'date',
        'production_completion' => 'date',
        'shipment_of_material' => 'date',
        'logistics_to_dry_port' => 'date',
        'clearance_of_material' => 'date',
        'delivery_to_site' => 'date',
        'planned_start_date' => 'date',
    ];
}
