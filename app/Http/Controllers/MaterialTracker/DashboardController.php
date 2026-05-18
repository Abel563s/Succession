<?php

namespace App\Http\Controllers\MaterialTracker;

use App\Http\Controllers\Controller;
use App\Models\MaterialTracker\Material;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMaterials = Material::count();
        $approvedMaterials = Material::where('approval', true)->count();
        $pendingApproval = Material::where('approval', false)->count();
        $materialsByProcurementType = Material::select('procurement_type', \DB::raw('count(*) as total'))
            ->groupBy('procurement_type')
            ->pluck('total', 'procurement_type');

        $recentMaterials = Material::latest()->take(5)->get();

        return view('material-tracker.dashboard', compact(
            'totalMaterials',
            'approvedMaterials',
            'pendingApproval',
            'materialsByProcurementType',
            'recentMaterials'
        ));
    }
}
