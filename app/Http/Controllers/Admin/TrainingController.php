<?php

namespace App\Http\Controllers\Admin;

use App\Models\Training;
use App\Services\HrSignatureService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TrainingController extends AdminHrModuleController
{
    public function __construct(
        protected HrSignatureService $signatures,
    ) {}

    public function index(Request $request): View
    {
        $query = Training::query();
        $this->scopeHrRecordsForUser($query);

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('search')) {
            $query->where('candidate_name', 'like', '%'.$request->search.'%');
        }

        $records = $query->latest()->paginate(10);
        $departments = $this->departmentsForUser();

        return view('admin.training.index', compact('records', 'departments'));
    }

    public function create(): View
    {
        $this->authorizeCreateHrRecord();
        $departments = $this->departmentsForUser();

        return view('admin.training.create', compact('departments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeCreateHrRecord();

        $request->validate([
            'candidate_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'line_manager' => 'required|string|max:255',
            'manager_sig' => 'nullable|image|max:500',
            'use_saved_signature' => 'nullable|boolean',
        ]);

        if (! $request->boolean('use_saved_signature') && ! $request->hasFile('manager_sig')) {
            return back()->withErrors(['manager_sig' => 'Manager signature is required.'])->withInput();
        }

        $this->assertNoDuplicateHrSubmission(Training::class, [
            'candidate_name' => $request->candidate_name,
            'department' => $request->department,
        ]);

        $managerSignature = $this->signatures->resolveManagerSignature($request, 'manager_sig', 'signatures/training/manager');

        $training = Training::query()->create([
            'candidate_name' => $request->candidate_name,
            'department' => $request->department,
            'line_manager' => $request->line_manager,
            'manager_signature' => $managerSignature,
            'created_by' => auth()->id(),
            'goal_1' => $request->goal_1,
            'skill_area_1' => $request->skill_area_1,
            'score_1' => $request->score_1,
            'goal_2' => $request->goal_2,
            'skill_area_2' => $request->skill_area_2,
            'score_2' => $request->score_2,
            'goal_3' => $request->goal_3,
            'skill_area_3' => $request->skill_area_3,
            'score_3' => $request->score_3,
            'activities' => $request->activities,
            'expected_outcomes' => $request->expected_outcomes,
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('admin.training.show', $training)->with('success', 'Training Program record created successfully. Pending approval.');
    }

    public function show(Training $training): View
    {
        $this->authorizeViewHrRecord($training);

        return view('admin.training.show', compact('training'));
    }

    public function edit(Training $training): View
    {
        $this->authorizeEditHrRecord($training);
        $departments = $this->departmentsForUser();

        return view('admin.training.edit', compact('training', 'departments'));
    }

    public function update(Request $request, Training $training): RedirectResponse
    {
        $this->authorizeEditHrRecord($training);

        $request->validate([
            'candidate_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'line_manager' => 'required|string|max:255',
            'manager_sig' => 'nullable|image|max:500',
            'use_saved_signature' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'candidate_name', 'department', 'line_manager',
            'goal_1', 'skill_area_1', 'score_1',
            'goal_2', 'skill_area_2', 'score_2',
            'goal_3', 'skill_area_3', 'score_3',
            'activities', 'expected_outcomes', 'feedback',
        ]);

        if ($request->boolean('use_saved_signature') && auth()->user()?->signature_path) {
            $data['manager_signature'] = auth()->user()->signature_path;
        } elseif ($request->hasFile('manager_sig')) {
            if ($training->manager_signature) {
                Storage::disk('public')->delete($training->manager_signature);
            }
            $data['manager_signature'] = $request->file('manager_sig')->store('signatures/training/manager', 'public');
        }

        $training->update($data);

        return redirect()->route('admin.training.index')->with('success', 'Training Program record updated successfully.');
    }

    public function destroy(Training $training): RedirectResponse
    {
        $this->authorizeDeleteHrRecord($training);

        $this->signatures->deletePublicFile($training->signature_path);
        $this->signatures->deletePublicFile($training->manager_signature);
        $this->signatures->deletePublicFile($training->candidate_signature);
        $training->delete();

        return redirect()->route('admin.training.index')->with('success', 'Training Program record deleted successfully.');
    }
}

