<?php

namespace App\Http\Controllers\MaterialTracker;

use App\Http\Controllers\Controller;
use App\Models\MaterialTracker\Material;
use App\Http\Requests\MaterialTracker\StoreMaterialRequest;
use App\Http\Requests\MaterialTracker\UpdateMaterialRequest;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::query();

        if ($request->filled('search')) {
            $query->where('material_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('project_site')) {
            $query->where('project_site', $request->project_site);
        }

        if ($request->filled('discipline')) {
            $query->where('discipline', $request->discipline);
        }

        if ($request->filled('approval')) {
            $query->where('approval', $request->approval == 'Yes' ? 1 : 0);
        }

        if ($request->filled('procurement_type')) {
            $query->where('procurement_type', $request->procurement_type);
        }

        $materials = $query->latest()->paginate(10);

        return view('material-tracker.materials.index', compact('materials'));
    }

    public function create()
    {
        return view('material-tracker.materials.create');
    }

    public function store(StoreMaterialRequest $request)
    {
        Material::create($request->validated());

        return redirect()->route('material-tracker.materials.index')
            ->with('success', 'Material created successfully.');
    }

    public function show(Material $material)
    {
        return view('material-tracker.materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        return view('material-tracker.materials.edit', compact('material'));
    }

    public function update(UpdateMaterialRequest $request, Material $material)
    {
        $material->update($request->validated());

        return redirect()->route('material-tracker.materials.index')
            ->with('success', 'Material updated successfully.');
    }

    public function destroy(Material $material)
    {
        $material->delete();

        return redirect()->route('material-tracker.materials.index')
            ->with('success', 'Material deleted successfully.');
    }
}
