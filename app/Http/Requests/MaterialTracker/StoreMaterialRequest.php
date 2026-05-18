<?php

namespace App\Http\Requests\MaterialTracker;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'material_name' => ['required', 'string', 'max:255'],
            'supplier_name' => ['required', 'string', 'max:255'],
            'project_site' => ['nullable', 'string', 'max:255'],
            'discipline' => ['required', 'in:Civil,MEP'],
            'procurement_product' => ['required', 'in:Material,Service'],
            'supply_route' => ['required', 'in:Import,Local'],
            'approval' => ['boolean'],
            'procurement_type' => ['required', 'in:LVA,RFQ-Local,RFQ-Import-Birr,RFQ-Import-USD,IFB-ICB,IFB-NCB,RFP,LTA'],

            'design_planned' => ['nullable', 'date'],
            'design_actual' => ['nullable', 'date'],
            'specification_preparation' => ['nullable', 'date'],
            'request_order' => ['nullable', 'date'],
            'supplier_identification' => ['nullable', 'date'],
            'material_submittal' => ['nullable', 'date'],
            'material_approval' => ['nullable', 'date'],
            'finance' => ['nullable', 'date'],
            'lc' => ['nullable', 'date'],
            'production_completion' => ['nullable', 'date'],
            'production_days' => ['nullable', 'integer', 'min:0'],
            'shipment_of_material' => ['nullable', 'date'],
            'shipment_days' => ['nullable', 'integer', 'min:0'],
            'logistics_to_dry_port' => ['nullable', 'date'],
            'clearance_of_material' => ['nullable', 'date'],
            'delivery_to_site' => ['nullable', 'date'],
            'planned_start_date' => ['nullable', 'date'],
        ];
    }
}
