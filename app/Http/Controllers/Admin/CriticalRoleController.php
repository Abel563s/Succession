<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CriticalRole;
use App\Models\Department;
use Illuminate\Support\Facades\Storage;

class CriticalRoleController extends Controller
{
    public function index(Request $request)
    {
        $query = CriticalRole::query();

        if (!auth()->user()->isAdmin()) {
            $deptName = auth()->user()->department ? auth()->user()->department->name : null;
            if ($deptName) {
                $query->where('department', $deptName);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        if ($request->filled('search')) {
            $query->where('employee_name', 'like', '%' . $request->search . '%')
                  ->orWhere('department', 'like', '%' . $request->search . '%')
                  ->orWhere('critical_role', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('vacancy_risk')) {
            $query->where('vacancy_risk', $request->vacancy_risk);
        }

        if ($request->filled('position_impact')) {
            $query->where('position_impact', $request->position_impact);
        }

        $records = $query->latest()->paginate(10);
        
        if (!auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }

        return view('admin.critical-roles.index', compact('records', 'departments'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }
        return view('admin.critical-roles.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'critical_role' => 'required|string|max:255',
            'position_status' => 'required|string',
            'vacancy_risk' => 'required|string',
            'position_impact' => 'required|string',
            'successor_1_name' => 'nullable|string|max:255',
            'successor_1_readiness' => 'nullable|string',
            'successor_2_name' => 'nullable|string|max:255',
            'successor_2_readiness' => 'nullable|string',
            'successor_3_name' => 'nullable|string|max:255',
            'successor_3_readiness' => 'nullable|string',
            'mitigation_plan' => 'required|string',
            'signature' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('signature')) {
            $path = $request->file('signature')->store('signatures', 'public');
            $validated['signature_path'] = $path;
        }

        CriticalRole::create($validated);

        return redirect()->route('admin.critical-roles.index')->with('success', 'Critical Role evaluation submitted successfully.');
    }

    public function show(CriticalRole $criticalRole)
    {
        return view('admin.critical-roles.show', compact('criticalRole'));
    }

    public function edit(CriticalRole $criticalRole)
    {
        if (!auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }
        return view('admin.critical-roles.edit', compact('criticalRole', 'departments'));
    }

    public function update(Request $request, CriticalRole $criticalRole)
    {
        $validated = $request->validate([
            'employee_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'critical_role' => 'required|string|max:255',
            'position_status' => 'required|string',
            'vacancy_risk' => 'required|string',
            'position_impact' => 'required|string',
            'successor_1_name' => 'nullable|string|max:255',
            'successor_1_readiness' => 'nullable|string',
            'successor_2_name' => 'nullable|string|max:255',
            'successor_2_readiness' => 'nullable|string',
            'successor_3_name' => 'nullable|string|max:255',
            'successor_3_readiness' => 'nullable|string',
            'mitigation_plan' => 'required|string',
            'signature' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('signature')) {
            // Delete old signature if exists
            if ($criticalRole->signature_path) {
                Storage::disk('public')->delete($criticalRole->signature_path);
            }
            $path = $request->file('signature')->store('signatures', 'public');
            $validated['signature_path'] = $path;
        }

        $criticalRole->update($validated);

        return redirect()->route('admin.critical-roles.index')->with('success', 'Critical Role evaluation updated successfully.');
    }

    public function destroy(CriticalRole $criticalRole)
    {
        if ($criticalRole->signature_path) {
            Storage::disk('public')->delete($criticalRole->signature_path);
        }
        $criticalRole->delete();

        return redirect()->route('admin.critical-roles.index')->with('success', 'Critical Role record deleted successfully.');
    }
}
