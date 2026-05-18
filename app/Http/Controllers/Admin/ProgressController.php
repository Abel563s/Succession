<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgressReview;
use App\Models\ProgressTrackingItem;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProgressController extends Controller
{
    public function index(Request $request)
    {
        $query = ProgressReview::query();

        if (!auth()->user()->isAdmin()) {
            $deptName = auth()->user()->department ? auth()->user()->department->name : null;
            if ($deptName) {
                $query->where('department', $deptName);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        if ($request->filled('search')) {
            $query->where('candidate_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $records = $query->latest()->paginate(10);
        
        if (!auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }

        return view('admin.progress.index', compact('records', 'departments'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }
        return view('admin.progress.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidate_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'line_manager' => 'required|string|max:255',
            'signature' => 'required|image|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except(['signature', 'review_date', 'achievements', 'challenges', 'next_steps']);
            
            if ($request->hasFile('signature')) {
                $data['signature_path'] = $request->file('signature')->store('signatures/progress', 'public');
            }

            $review = ProgressReview::create($data);

            if ($request->has('review_date')) {
                foreach ($request->review_date as $key => $date) {
                    if ($date) {
                        ProgressTrackingItem::create([
                            'progress_review_id' => $review->id,
                            'review_date' => $date,
                            'achievements' => $request->achievements[$key] ?? null,
                            'challenges' => $request->challenges[$key] ?? null,
                            'next_steps' => $request->next_steps[$key] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.progress.index')->with('success', 'Progress Review created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating review: ' . $e->getMessage());
        }
    }

    public function show(ProgressReview $progress)
    {
        $progress->load('trackingItems');
        return view('admin.progress.show', compact('progress'));
    }

    public function edit(ProgressReview $progress)
    {
        $progress->load('trackingItems');
        if (!auth()->user()->isAdmin()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }
        return view('admin.progress.edit', compact('progress', 'departments'));
    }

    public function update(Request $request, ProgressReview $progress)
    {
        $request->validate([
            'candidate_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'line_manager' => 'required|string|max:255',
            'signature' => 'nullable|image|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except(['_token', '_method', 'signature', 'review_date', 'achievements', 'challenges', 'next_steps']);

            if ($request->hasFile('signature')) {
                if ($progress->signature_path) {
                    Storage::disk('public')->delete($progress->signature_path);
                }
                $data['signature_path'] = $request->file('signature')->store('signatures/progress', 'public');
            }

            $progress->update($data);

            // Sync Tracking Items
            $progress->trackingItems()->delete();
            if ($request->has('review_date')) {
                foreach ($request->review_date as $key => $date) {
                    if ($date) {
                        ProgressTrackingItem::create([
                            'progress_review_id' => $progress->id,
                            'review_date' => $date,
                            'achievements' => $request->achievements[$key] ?? null,
                            'challenges' => $request->challenges[$key] ?? null,
                            'next_steps' => $request->next_steps[$key] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.progress.index')->with('success', 'Progress Review updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating review: ' . $e->getMessage());
        }
    }

    public function destroy(ProgressReview $progress)
    {
        if ($progress->signature_path) {
            Storage::disk('public')->delete($progress->signature_path);
        }
        $progress->delete();
        return redirect()->route('admin.progress.index')->with('success', 'Progress Review deleted successfully.');
    }
}
