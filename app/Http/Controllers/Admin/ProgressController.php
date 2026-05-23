<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProgressIdpObjective;
use App\Models\ProgressReview;
use App\Models\ProgressTrackingItem;
use App\Services\HrSignatureService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProgressController extends AdminHrModuleController
{
    public function __construct(
        protected HrSignatureService $signatures,
    ) {}

    public function index(Request $request): View
    {
        $query = ProgressReview::query()->with('development');
        $this->scopeHrRecordsForUser($query);

        if ($request->filled('search')) {
            $query->where('candidate_name', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $records = $query->latest()->paginate(10);
        $departments = $this->departmentsForUser();

        return view('admin.progress.index', compact('records', 'departments'));
    }

    public function create(): View
    {
        $this->authorizeCreateHrRecord();
        $departments = $this->departmentsForUser();

        return view('admin.progress.create', compact('departments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeCreateHrRecord();

        $request->validate([
            'candidate_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'line_manager' => 'required|string|max:255',
            'signature' => 'nullable|image|max:500',
            'use_saved_signature' => 'nullable|boolean',
            'idp_objectives' => 'nullable|array',
            'idp_objectives.*.score' => 'nullable|string|max:50',
        ]);

        if (! $request->boolean('use_saved_signature') && ! $request->hasFile('signature')) {
            return back()->withErrors(['signature' => 'Manager signature is required.'])->withInput();
        }

        $this->assertNoDuplicateHrSubmission(ProgressReview::class, [
            'candidate_name' => $request->candidate_name,
            'department' => $request->department,
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except(['signature', 'review_date', 'achievements', 'challenges', 'next_steps', 'idp_objectives', 'use_saved_signature']);
            $data['created_by'] = auth()->id();
            $data['signature_path'] = $this->signatures->resolveManagerSignature($request, 'signature', 'signatures/progress');

            $review = ProgressReview::query()->create($data);

            $this->syncTrackingItems($request, $review);
            $this->syncIdpObjectives($request, $review);

            DB::commit();

            return redirect()->route('admin.progress.show', $review)->with('success', 'Progress Review created successfully. Pending approval.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Error creating review: '.$e->getMessage());
        }
    }

    public function show(ProgressReview $progress): View
    {
        $this->authorizeViewHrRecord($progress);
        $progress->load(['trackingItems', 'idpObjectives', 'development']);

        return view('admin.progress.show', compact('progress'));
    }

    public function edit(ProgressReview $progress): View
    {
        $this->authorizeEditHrRecord($progress);
        $progress->load(['trackingItems', 'idpObjectives', 'development']);
        $departments = $this->departmentsForUser();

        return view('admin.progress.edit', compact('progress', 'departments'));
    }

    public function update(Request $request, ProgressReview $progress): RedirectResponse
    {
        $this->authorizeEditHrRecord($progress);

        $request->validate([
            'candidate_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'line_manager' => 'required|string|max:255',
            'signature' => 'nullable|image|max:500',
            'use_saved_signature' => 'nullable|boolean',
            'idp_objectives' => 'nullable|array',
            'idp_objectives.*.score' => 'nullable|string|max:50',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except(['_token', '_method', 'signature', 'review_date', 'achievements', 'challenges', 'next_steps', 'idp_objectives', 'use_saved_signature']);

            if ($request->boolean('use_saved_signature') && auth()->user()?->signature_path) {
                $data['signature_path'] = auth()->user()->signature_path;
            } elseif ($request->hasFile('signature')) {
                $this->signatures->deletePublicFile($progress->signature_path);
                $data['signature_path'] = $request->file('signature')->store('signatures/progress', 'public');
            }

            $progress->update($data);

            $progress->trackingItems()->delete();
            $this->syncTrackingItems($request, $progress);
            $this->syncIdpObjectives($request, $progress);

            DB::commit();

            return redirect()->route('admin.progress.index')->with('success', 'Progress Review updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Error updating review: '.$e->getMessage());
        }
    }

    public function destroy(ProgressReview $progress): RedirectResponse
    {
        $this->authorizeDeleteHrRecord($progress);

        $this->signatures->deletePublicFile($progress->signature_path);
        $progress->delete();

        return redirect()->route('admin.progress.index')->with('success', 'Progress Review deleted successfully.');
    }

    protected function syncTrackingItems(Request $request, ProgressReview $review): void
    {
        if (! $request->has('review_date')) {
            return;
        }

        foreach ($request->review_date as $key => $date) {
            if ($date) {
                ProgressTrackingItem::query()->create([
                    'progress_review_id' => $review->id,
                    'review_date' => $date,
                    'achievements' => $request->achievements[$key] ?? null,
                    'challenges' => $request->challenges[$key] ?? null,
                    'next_steps' => $request->next_steps[$key] ?? null,
                ]);
            }
        }
    }

    protected function syncIdpObjectives(Request $request, ProgressReview $review): void
    {
        if (! $request->has('idp_objectives')) {
            return;
        }

        foreach ($request->input('idp_objectives', []) as $objectiveId => $data) {
            ProgressIdpObjective::query()
                ->where('progress_review_id', $review->id)
                ->where('id', $objectiveId)
                ->update(['score' => $data['score'] ?? null]);
        }
    }
}
