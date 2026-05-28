<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\Succession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuccessionController extends AdminHrModuleController
{
    public function index(Request $request)
    {
        $query = Succession::query();

        $this->scopeHrRecordsForUser($query);

        if ($request->filled('search')) {
            $query->where('candidate_name', 'like', '%'.$request->search.'%')
                ->orWhere('department', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('readiness_level')) {
            $query->where('readiness_level', $request->readiness_level);
        }

        $records = $query->latest()->paginate(10);

        if (! auth()->user()->isAdmin() && ! auth()->user()->isDceo()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }

        return view('admin.successions.index', compact('records', 'departments'));
    }

    public function create()
    {
        $this->authorizeCreateHrRecord();

        if (! auth()->user()->isAdmin() && ! auth()->user()->isDceo()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }

        return view('admin.successions.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $this->authorizeCreateHrRecord();

        $validated = $request->validate([
            'candidate_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'line_manager' => 'required|string|max:255',
            'years_experience' => 'required|string',
            'target_role' => 'required|string|max:255',
            'core_competencies' => 'required|string',
            'technical_competencies' => 'required|string',
            'justification' => 'required|string',
            'okr_achievement' => 'required|string',
            'readiness_level' => 'required|string',
            'ipg_score' => 'required|string',
            'signature' => auth()->user()->signature_path ? 'nullable|image|max:500' : 'required|image|max:500',
        ]);

        if ($request->hasFile('signature')) {
            $path = $request->file('signature')->store('signatures/successions', 'public');
            $validated['signature_path'] = $path;
        } elseif (auth()->user()->signature_path) {
            $validated['signature_path'] = auth()->user()->signature_path;
        }

        $validated['created_by'] = auth()->id();
        $succession = Succession::create($validated);

        return redirect()->route('admin.successions.show', $succession)->with('success', 'Succession planning nomination submitted successfully. Pending approval.');
    }

    public function show(Succession $succession)
    {
        return view('admin.successions.show', compact('succession'));
    }

    public function edit(Succession $succession)
    {
        if (! auth()->user()->isAdmin() && ! auth()->user()->isDceo()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }

        return view('admin.successions.edit', compact('succession', 'departments'));
    }

    public function update(Request $request, Succession $succession)
    {
        $validated = $request->validate([
            'candidate_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'line_manager' => 'required|string|max:255',
            'years_experience' => 'required|string',
            'target_role' => 'required|string|max:255',
            'core_competencies' => 'required|string',
            'technical_competencies' => 'required|string',
            'justification' => 'required|string',
            'okr_achievement' => 'required|string',
            'readiness_level' => 'required|string',
            'ipg_score' => 'required|string',
            'signature' => 'nullable|image|max:500',
        ]);

        if ($request->hasFile('signature')) {
            if ($succession->signature_path) {
                Storage::disk('public')->delete($succession->signature_path);
            }
            $path = $request->file('signature')->store('signatures/successions', 'public');
            $validated['signature_path'] = $path;
        }

        $succession->update($validated);

        return redirect()->route('admin.successions.index')->with('success', 'Succession planning nomination updated successfully.');
    }

    public function destroy(Succession $succession)
    {
        if ($succession->signature_path) {
            Storage::disk('public')->delete($succession->signature_path);
        }
        $succession->delete();

        return redirect()->route('admin.successions.index')->with('success', 'Succession record deleted successfully.');
    }
}
