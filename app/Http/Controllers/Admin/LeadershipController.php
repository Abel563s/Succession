<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\LeadershipAssessment;
use App\Models\LeadershipCompetencyRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LeadershipController extends AdminHrModuleController
{
    public function index(Request $request)
    {
        $query = LeadershipAssessment::query();

        $this->scopeHrRecordsForUser($query);

        if ($request->filled('search')) {
            $query->where('candidate_name', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $records = $query->latest()->paginate(10);

        if (! auth()->user()->isAdmin() && ! auth()->user()->isDceo()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }

        return view('admin.leadership.index', compact('records', 'departments'));
    }

    public function create()
    {
        if (! auth()->user()->isAdmin() && ! auth()->user()->isDceo()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }
        $competencies = [
            'Business Insight',
            'Inspirational Leadership',
            'Results-Oriented',
            'Stewardship',
            'Talent Management',
            'Vision and Strategic Thinking',
        ];

        return view('admin.leadership.create', compact('departments', 'competencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidate_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'line_manager' => 'required|string|max:255',
            'signature' => 'nullable|image|max:500',
            'ratings' => 'required|array',
            'ratings.*' => 'required|integer|min:1|max:5',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->only(['candidate_name', 'department', 'line_manager', 'comments', 'status']);

            if ($request->hasFile('signature')) {
                $data['signature_path'] = $request->file('signature')->store('signatures/leadership', 'public');
            }

            // Calculate overall score
            $totalRatings = count($request->ratings);
            $sumRatings = array_sum($request->ratings);
            $data['overall_score'] = $totalRatings > 0 ? $sumRatings / $totalRatings : 0;

            $data['created_by'] = auth()->id();
            $assessment = LeadershipAssessment::create($data);

            foreach ($request->ratings as $name => $rating) {
                LeadershipCompetencyRating::create([
                    'leadership_assessment_id' => $assessment->id,
                    'competency_name' => $name,
                    'rating' => $rating,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.leadership.show', $assessment)->with('success', 'Leadership Assessment created successfully. Pending approval.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Error creating assessment: '.$e->getMessage());
        }
    }

    public function show(LeadershipAssessment $leadership)
    {
        $leadership->load('ratings');

        return view('admin.leadership.show', compact('leadership'));
    }

    public function edit(LeadershipAssessment $leadership)
    {
        $leadership->load('ratings');
        if (! auth()->user()->isAdmin() && ! auth()->user()->isDceo()) {
            $departments = Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = Department::orderBy('name')->get();
        }
        $competencies = [
            'Business Insight',
            'Inspirational Leadership',
            'Results-Oriented',
            'Stewardship',
            'Talent Management',
            'Vision and Strategic Thinking',
        ];

        return view('admin.leadership.edit', compact('leadership', 'departments', 'competencies'));
    }

    public function update(Request $request, LeadershipAssessment $leadership)
    {
        $request->validate([
            'candidate_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'line_manager' => 'required|string|max:255',
            'signature' => 'nullable|image|max:500',
            'ratings' => 'required|array',
            'ratings.*' => 'required|integer|min:1|max:5',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->only(['candidate_name', 'department', 'line_manager', 'comments', 'status']);

            if ($request->hasFile('signature')) {
                if ($leadership->signature_path) {
                    Storage::disk('public')->delete($leadership->signature_path);
                }
                $data['signature_path'] = $request->file('signature')->store('signatures/leadership', 'public');
            }

            // Calculate overall score
            $totalRatings = count($request->ratings);
            $sumRatings = array_sum($request->ratings);
            $data['overall_score'] = $totalRatings > 0 ? $sumRatings / $totalRatings : 0;

            $leadership->update($data);

            $leadership->ratings()->delete();
            foreach ($request->ratings as $name => $rating) {
                LeadershipCompetencyRating::create([
                    'leadership_assessment_id' => $leadership->id,
                    'competency_name' => $name,
                    'rating' => $rating,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.leadership.index')->with('success', 'Leadership Assessment updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Error updating assessment: '.$e->getMessage());
        }
    }

    public function destroy(LeadershipAssessment $leadership)
    {
        if ($leadership->signature_path) {
            Storage::disk('public')->delete($leadership->signature_path);
        }
        $leadership->delete();

        return redirect()->route('admin.leadership.index')->with('success', 'Leadership Assessment deleted successfully.');
    }
}

