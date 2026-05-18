<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainingController extends Controller
{
    public function index(Request $request)
    {
        $query = Training::query();

        if (!auth()->user()->isAdmin()) {
            $deptName = auth()->user()->department ? auth()->user()->department->name : null;
            if ($deptName) {
                $query->where('department', $deptName);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('search')) {
            $query->where('candidate_name', 'like', '%' . $request->search . '%');
        }

        $records = $query->latest()->paginate(10);
        
        if (!auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }

        return view('admin.training.index', compact('records', 'departments'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }
        return view('admin.training.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidate_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'line_manager' => 'required|string|max:255',
            'manager_sig' => 'required|image|max:2048',
            'candidate_sig' => 'required|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('manager_sig')) {
            $data['manager_signature'] = $request->file('manager_sig')->store('signatures/training/manager', 'public');
        }

        if ($request->hasFile('candidate_sig')) {
            $data['candidate_signature'] = $request->file('candidate_sig')->store('signatures/training/candidate', 'public');
        }

        Training::create($data);

        return redirect()->route('admin.training.index')->with('success', 'Training Program record created successfully.');
    }

    public function show(Training $training)
    {
        return view('admin.training.show', compact('training'));
    }

    public function edit(Training $training)
    {
        if (!auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }
        return view('admin.training.edit', compact('training', 'departments'));
    }

    public function update(Request $request, Training $training)
    {
        $request->validate([
            'candidate_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'line_manager' => 'required|string|max:255',
            'manager_sig' => 'nullable|image|max:2048',
            'candidate_sig' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('manager_sig')) {
            if ($training->manager_signature) {
                Storage::disk('public')->delete($training->manager_signature);
            }
            $data['manager_signature'] = $request->file('manager_sig')->store('signatures/training/manager', 'public');
        }

        if ($request->hasFile('candidate_sig')) {
            if ($training->candidate_signature) {
                Storage::disk('public')->delete($training->candidate_signature);
            }
            $data['candidate_signature'] = $request->file('candidate_sig')->store('signatures/training/candidate', 'public');
        }

        $training->update($data);

        return redirect()->route('admin.training.index')->with('success', 'Training Program record updated successfully.');
    }

    public function destroy(Training $training)
    {
        if ($training->signature_path) {
            Storage::disk('public')->delete($training->signature_path);
        }
        if ($training->manager_signature) {
            Storage::disk('public')->delete($training->manager_signature);
        }
        if ($training->candidate_signature) {
            Storage::disk('public')->delete($training->candidate_signature);
        }
        $training->delete();

        return redirect()->route('admin.training.index')->with('success', 'Training Program record deleted successfully.');
    }
}
