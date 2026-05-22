<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\SuccessionDashboard;
use App\Models\SuccessionDashboardItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SuccessionDashboardController extends AdminHrModuleController
{
    public function index(Request $request)
    {
        $query = SuccessionDashboard::query();

        if (! auth()->user()->isAdmin()) {
            $deptName = auth()->user()->department ? auth()->user()->department->name : null;
            if ($deptName) {
                $query->where('department', $deptName);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $records = $query->latest()->paginate(10);

        if (! auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }

        return view('admin.sd.index', compact('records', 'departments'));
    }

    public function create()
    {
        if (! auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }

        return view('admin.sd.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'signature' => 'nullable|image|max:2048',
            'position.*' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->only(['title', 'department', 'status']);

            if ($request->hasFile('signature')) {
                $data['signature_path'] = $request->file('signature')->store('signatures/sd', 'public');
            }

            $dashboard = SuccessionDashboard::create($data);

            if ($request->has('position')) {
                foreach ($request->position as $key => $pos) {
                    SuccessionDashboardItem::create([
                        'succession_dashboard_id' => $dashboard->id,
                        'position' => $pos,
                        'current_holder' => $request->current_holder[$key],
                        'candidates' => $request->candidates[$key],
                        'timeline_progress' => $request->timeline_progress[$key] ?? null,
                        'competency_progress' => $request->competency_progress[$key] ?? null,
                        'development_progress' => $request->development_progress[$key] ?? null,
                        'kpi_metrics' => $request->kpi_metrics[$key] ?? null,
                        'monitoring_progress' => $request->monitoring_progress[$key] ?? null,
                        'readiness_rating' => $request->readiness_rating[$key],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.sd.show', $dashboard)->with('success', 'Succession Dashboard created successfully. Pending approval.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Error creating dashboard: '.$e->getMessage());
        }
    }

    public function show(SuccessionDashboard $sd)
    {
        $sd->load('items');

        return view('admin.sd.show', compact('sd'));
    }

    public function edit(SuccessionDashboard $sd)
    {
        $sd->load('items');
        if (! auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }

        return view('admin.sd.edit', compact('sd', 'departments'));
    }

    public function update(Request $request, SuccessionDashboard $sd)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'signature' => 'nullable|image|max:2048',
            'position.*' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->only(['title', 'department', 'status']);

            if ($request->hasFile('signature')) {
                if ($sd->signature_path) {
                    Storage::disk('public')->delete($sd->signature_path);
                }
                $data['signature_path'] = $request->file('signature')->store('signatures/sd', 'public');
            }

            $sd->update($data);

            $sd->items()->delete();
            if ($request->has('position')) {
                foreach ($request->position as $key => $pos) {
                    SuccessionDashboardItem::create([
                        'succession_dashboard_id' => $sd->id,
                        'position' => $pos,
                        'current_holder' => $request->current_holder[$key],
                        'candidates' => $request->candidates[$key],
                        'timeline_progress' => $request->timeline_progress[$key] ?? null,
                        'competency_progress' => $request->competency_progress[$key] ?? null,
                        'development_progress' => $request->development_progress[$key] ?? null,
                        'kpi_metrics' => $request->kpi_metrics[$key] ?? null,
                        'monitoring_progress' => $request->monitoring_progress[$key] ?? null,
                        'readiness_rating' => $request->readiness_rating[$key],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.sd.index')->with('success', 'Succession Dashboard updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Error updating dashboard: '.$e->getMessage());
        }
    }

    public function destroy(SuccessionDashboard $sd)
    {
        if ($sd->signature_path) {
            Storage::disk('public')->delete($sd->signature_path);
        }
        $sd->delete();

        return redirect()->route('admin.sd.index')->with('success', 'Succession Dashboard deleted successfully.');
    }
}
