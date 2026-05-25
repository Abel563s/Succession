<?php

namespace App\Http\Controllers\Admin;

use App\Models\CriticalRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CriticalRoleController extends AdminHrModuleController
{
    public function index(Request $request): View
    {
        $query = CriticalRole::query();
        $this->scopeHrRecordsForUser($query);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('employee_name', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhere('critical_role', 'like', "%{$search}%");
            });
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
        $departments = $this->departmentsForUser();

        return view('admin.critical-roles.index', compact('records', 'departments'));
    }

    public function create(): View
    {
        $this->authorizeCreateHrRecord();

        return view('admin.critical-roles.create', ['departments' => $this->departmentsForUser()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeCreateHrRecord();

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
            'signature' => 'required|image|max:500',
        ]);

        $this->assertNoDuplicateHrSubmission(CriticalRole::class, [
            'employee_name' => $validated['employee_name'],
            'department' => $validated['department'],
        ]);

        if ($request->hasFile('signature')) {
            $validated['signature_path'] = $request->file('signature')->store('signatures', 'public');
        }

        $validated['created_by'] = auth()->id();
        $criticalRole = CriticalRole::query()->create($validated);

        return redirect()->route('admin.critical-roles.show', $criticalRole)->with('success', 'Critical Role evaluation submitted successfully. Pending approval.');
    }

    public function show(CriticalRole $criticalRole): View
    {
        $this->authorizeViewHrRecord($criticalRole);

        return view('admin.critical-roles.show', compact('criticalRole'));
    }

    public function edit(CriticalRole $criticalRole): View
    {
        $this->authorizeEditHrRecord($criticalRole);

        return view('admin.critical-roles.edit', [
            'criticalRole' => $criticalRole,
            'departments' => $this->departmentsForUser(),
        ]);
    }

    public function update(Request $request, CriticalRole $criticalRole): RedirectResponse
    {
        $this->authorizeEditHrRecord($criticalRole);

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
            'signature' => 'nullable|image|max:500',
        ]);

        if ($request->hasFile('signature')) {
            if ($criticalRole->signature_path) {
                Storage::disk('public')->delete($criticalRole->signature_path);
            }
            $validated['signature_path'] = $request->file('signature')->store('signatures', 'public');
        }

        $criticalRole->update($validated);

        return redirect()->route('admin.critical-roles.index')->with('success', 'Critical Role evaluation updated successfully.');
    }

    public function destroy(CriticalRole $criticalRole): RedirectResponse
    {
        $this->authorizeDeleteHrRecord($criticalRole);

        if ($criticalRole->signature_path) {
            Storage::disk('public')->delete($criticalRole->signature_path);
        }
        $criticalRole->delete();

        return redirect()->route('admin.critical-roles.index')->with('success', 'Critical Role record deleted successfully.');
    }
}

