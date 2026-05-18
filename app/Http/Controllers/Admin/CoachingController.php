<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coaching;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoachingController extends Controller
{
    public function index(Request $request)
    {
        $query = Coaching::query();

        if (!auth()->user()->isAdmin()) {
            $deptName = auth()->user()->department ? auth()->user()->department->name : null;
            if ($deptName) {
                $query->where('department', $deptName);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('candidate_name', 'like', '%' . $request->search . '%')
                  ->orWhere('supervisor', 'like', '%' . $request->search . '%')
                  ->orWhere('department', 'like', '%' . $request->search . '%')
                  ->orWhere('topic_1', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('coaching_date')) {
            $query->whereDate('coaching_date', $request->coaching_date);
        }

        $records = $query->latest()->paginate(10);

        if (!auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }

        return view('admin.coaching.index', compact('records', 'departments'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }
        return view('admin.coaching.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidate_name' => 'required|string|max:255',
            'supervisor' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'coaching_date' => 'required|date',
            'manager_sig' => 'required|image|max:2048',
            'candidate_sig' => 'required|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('manager_sig')) {
            $data['manager_signature'] = $request->file('manager_sig')->store('signatures/coaching/manager', 'public');
        }

        if ($request->hasFile('candidate_sig')) {
            $data['candidate_signature'] = $request->file('candidate_sig')->store('signatures/coaching/candidate', 'public');
        }

        Coaching::create($data);

        return redirect()->route('admin.coaching.index')->with('success', 'Employee Coaching record created successfully.');
    }

    public function show(Coaching $coaching)
    {
        return view('admin.coaching.show', compact('coaching'));
    }

    public function edit(Coaching $coaching)
    {
        if (!auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }
        return view('admin.coaching.edit', compact('coaching', 'departments'));
    }

    public function update(Request $request, Coaching $coaching)
    {
        $request->validate([
            'candidate_name' => 'required|string|max:255',
            'supervisor' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'coaching_date' => 'required|date',
            'manager_sig' => 'nullable|image|max:2048',
            'candidate_sig' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('manager_sig')) {
            if ($coaching->manager_signature) {
                Storage::disk('public')->delete($coaching->manager_signature);
            }
            $data['manager_signature'] = $request->file('manager_sig')->store('signatures/coaching/manager', 'public');
        }

        if ($request->hasFile('candidate_sig')) {
            if ($coaching->candidate_signature) {
                Storage::disk('public')->delete($coaching->candidate_signature);
            }
            $data['candidate_signature'] = $request->file('candidate_sig')->store('signatures/coaching/candidate', 'public');
        }

        $coaching->update($data);

        return redirect()->route('admin.coaching.index')->with('success', 'Employee Coaching record updated successfully.');
    }

    public function destroy(Coaching $coaching)
    {
        if ($coaching->manager_signature) {
            Storage::disk('public')->delete($coaching->manager_signature);
        }
        if ($coaching->candidate_signature) {
            Storage::disk('public')->delete($coaching->candidate_signature);
        }
        $coaching->delete();

        return redirect()->route('admin.coaching.index')->with('success', 'Employee Coaching record deleted successfully.');
    }
}
