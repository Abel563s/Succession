<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MentorController extends AdminHrModuleController
{
    public function index(Request $request)
    {
        $query = Mentor::query();

        if (! auth()->user()->isAdmin()) {
            $deptName = auth()->user()->department ? auth()->user()->department->name : null;
            if ($deptName) {
                $query->where('department', $deptName);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('mentor_name', 'like', "%{$search}%")
                    ->orWhere('mentee_name', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $records = $query->latest()->paginate(10)->withQueryString();

        if (! auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }

        return view('admin.mentor.index', compact('records', 'departments'));
    }

    public function create()
    {
        if (! auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }

        return view('admin.mentor.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mentor_name' => 'required|string|max:255',
            'mentee_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'signature' => 'required|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('signature')) {
            $data['signature_path'] = $request->file('signature')->store('signatures/mentor', 'public');
        }

        $mentor = Mentor::create($data);

        return redirect()->route('admin.mentor.show', $mentor)->with('success', 'Mentor Feedback record created successfully. Pending approval.');
    }

    public function show(Mentor $mentor)
    {
        return view('admin.mentor.show', compact('mentor'));
    }

    public function edit(Mentor $mentor)
    {
        if (! auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }

        return view('admin.mentor.edit', compact('mentor', 'departments'));
    }

    public function update(Request $request, Mentor $mentor)
    {
        $request->validate([
            'mentor_name' => 'required|string|max:255',
            'mentee_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'signature' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('signature')) {
            if ($mentor->signature_path) {
                Storage::disk('public')->delete($mentor->signature_path);
            }
            $data['signature_path'] = $request->file('signature')->store('signatures/mentor', 'public');
        }

        $mentor->update($data);

        return redirect()->route('admin.mentor.index')->with('success', 'Mentor Feedback record updated successfully.');
    }

    public function destroy(Mentor $mentor)
    {
        if ($mentor->signature_path) {
            Storage::disk('public')->delete($mentor->signature_path);
        }
        $mentor->delete();

        return redirect()->route('admin.mentor.index')->with('success', 'Mentor Feedback record deleted successfully.');
    }
}
