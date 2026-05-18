<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Development;
use App\Models\IdpObjective;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DevelopmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Development::with('objectives');

        if (!auth()->user()->isAdmin()) {
            $deptName = auth()->user()->department ? auth()->user()->department->name : null;
            if ($deptName) {
                $query->where('department', $deptName);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('employee_name', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('line_manager', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $records = $query->latest()->paginate(10)->withQueryString();
        
        if (!auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }

        return view('admin.development.index', compact('records', 'departments'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }
        return view('admin.development.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'line_manager' => 'required|string|max:255',
            'signature' => 'required|image|max:2048',
            'objectives' => 'required|array',
            'objectives.*.objective' => 'nullable|string',
            'objectives.*.activity' => 'nullable|string',
            'objectives.*.resource' => 'nullable|string',
            'objectives.*.start_date' => 'nullable|date',
            'objectives.*.delivery_date' => 'nullable|date',
            'objectives.*.expected_outcome' => 'nullable|string',
            'objectives.*.score' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $path = $request->file('signature')->store('signatures/development', 'public');

            $development = Development::create([
                'employee_name' => $validated['employee_name'],
                'department' => $validated['department'],
                'line_manager' => $validated['line_manager'],
                'signature_path' => $path,
            ]);

            foreach ($validated['objectives'] as $rowNumber => $data) {
                // Only save rows that have at least some content
                if (array_filter($data)) {
                    $development->objectives()->create(array_merge($data, [
                        'row_number' => $rowNumber + 1
                    ]));
                }
            }

            DB::commit();
            return redirect()->route('admin.development.index')->with('success', 'Individual Development Plan created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'An error occurred while saving the IDP: ' . $e->getMessage());
        }
    }

    public function show(Development $development)
    {
        $development->load('objectives');
        return view('admin.development.show', compact('development'));
    }

    public function edit(Development $development)
    {
        $development->load('objectives');
        if (!auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }
        return view('admin.development.edit', compact('development', 'departments'));
    }

    public function update(Request $request, Development $development)
    {
        $validated = $request->validate([
            'employee_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'line_manager' => 'required|string|max:255',
            'signature' => 'nullable|image|max:2048',
            'objectives' => 'required|array',
            'objectives.*.objective' => 'nullable|string',
            'objectives.*.activity' => 'nullable|string',
            'objectives.*.resource' => 'nullable|string',
            'objectives.*.start_date' => 'nullable|date',
            'objectives.*.delivery_date' => 'nullable|date',
            'objectives.*.expected_outcome' => 'nullable|string',
            'objectives.*.score' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('signature')) {
                if ($development->signature_path) {
                    Storage::disk('public')->delete($development->signature_path);
                }
                $path = $request->file('signature')->store('signatures/development', 'public');
                $development->signature_path = $path;
            }

            $development->update([
                'employee_name' => $validated['employee_name'],
                'department' => $validated['department'],
                'line_manager' => $validated['line_manager'],
            ]);

            // Update objectives: easiest to delete and recreate for this structure
            $development->objectives()->delete();

            foreach ($validated['objectives'] as $rowNumber => $data) {
                if (array_filter($data)) {
                    $development->objectives()->create(array_merge($data, [
                        'row_number' => $rowNumber + 1
                    ]));
                }
            }

            DB::commit();
            return redirect()->route('admin.development.index')->with('success', 'Individual Development Plan updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'An error occurred while updating the IDP: ' . $e->getMessage());
        }
    }

    public function destroy(Development $development)
    {
        if ($development->signature_path) {
            Storage::disk('public')->delete($development->signature_path);
        }
        $development->delete();

        return redirect()->route('admin.development.index')->with('success', 'Individual Development Plan deleted successfully.');
    }
}
