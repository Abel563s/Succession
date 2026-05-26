<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\NineBoxGrid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NineBoxController extends AdminHrModuleController
{
    public function index(Request $request)
    {
        $query = NineBoxGrid::query();

        $this->scopeHrRecordsForUser($query);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('candidate_name', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhere('grid_position', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $records = $query->latest()->paginate(10)->withQueryString();

        if (! auth()->user()->isAdmin() && ! auth()->user()->isDceo()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }

        return view('admin.nine-box.index', compact('records', 'departments'));
    }

    public function create()
    {
        if (! auth()->user()->isAdmin() && ! auth()->user()->isDceo()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }

        return view('admin.nine-box.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'candidate_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'grid_position' => 'required|string',
            'potential_level' => 'required|string',
            'performance_level' => 'required|string',
            'general_comments' => 'required|string',
            'strengths' => 'required|string',
            'development_needs' => 'required|string',
            'signature' => auth()->user()->signature_path ? 'nullable|image|max:500' : 'required|image|max:500',
        ]);

        if ($request->hasFile('signature')) {
            $path = $request->file('signature')->store('signatures/nine-box', 'public');
            $validated['signature_path'] = $path;
        } elseif (auth()->user()->signature_path) {
            $validated['signature_path'] = auth()->user()->signature_path;
        }

        $validated['created_by'] = auth()->id();
        $nineBox = NineBoxGrid::create($validated);

        return redirect()->route('admin.nine-box.show', $nineBox)->with('success', '9-Box Grid evaluation submitted successfully. Pending approval.');
    }

    public function show(NineBoxGrid $nineBox)
    {
        return view('admin.nine-box.show', compact('nineBox'));
    }

    public function edit(NineBoxGrid $nineBox)
    {
        if (! auth()->user()->isAdmin() && ! auth()->user()->isDceo()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }

        return view('admin.nine-box.edit', compact('nineBox', 'departments'));
    }

    public function update(Request $request, NineBoxGrid $nineBox)
    {
        $validated = $request->validate([
            'candidate_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'grid_position' => 'required|string',
            'potential_level' => 'required|string',
            'performance_level' => 'required|string',
            'general_comments' => 'required|string',
            'strengths' => 'required|string',
            'development_needs' => 'required|string',
            'signature' => 'nullable|image|max:500',
        ]);

        if ($request->hasFile('signature')) {
            if ($nineBox->signature_path) {
                Storage::disk('public')->delete($nineBox->signature_path);
            }
            $path = $request->file('signature')->store('signatures/nine-box', 'public');
            $validated['signature_path'] = $path;
        }

        $nineBox->update($validated);

        return redirect()->route('admin.nine-box.index')->with('success', '9-Box Grid evaluation updated successfully.');
    }

    public function destroy(NineBoxGrid $nineBox)
    {
        if ($nineBox->signature_path) {
            Storage::disk('public')->delete($nineBox->signature_path);
        }
        $nineBox->delete();

        return redirect()->route('admin.nine-box.index')->with('success', '9-Box Grid record deleted successfully.');
    }
}

