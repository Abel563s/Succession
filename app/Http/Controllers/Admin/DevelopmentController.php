<?php

namespace App\Http\Controllers\Admin;

use App\Models\Development;
use App\Services\DevelopmentProgressWorkflow;
use App\Services\HrSignatureService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DevelopmentController extends AdminHrModuleController
{
    public function __construct(
        protected HrSignatureService $signatures,
        protected DevelopmentProgressWorkflow $progressWorkflow,
    ) {}

    public function index(Request $request): View
    {
        $query = Development::query()->with('objectives');
        $this->scopeHrRecordsForUser($query);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('employee_name', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhere('line_manager', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $records = $query->latest()->paginate(10)->withQueryString();
        $departments = $this->departmentsForUser();

        return view('admin.development.index', compact('records', 'departments'));
    }

    public function create(): View
    {
        $this->authorizeCreateHrRecord();
        $departments = $this->departmentsForUser();

        return view('admin.development.create', compact('departments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeCreateHrRecord();

        $validated = $request->validate([
            'employee_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'line_manager' => 'required|string|max:255',
            'signature' => 'nullable|image|max:500',
            'candidate_signature' => 'required|image|max:500',
            'use_saved_signature' => 'nullable|boolean',
            'objectives' => 'required|array|size:5',
            'objectives.*.objective' => 'required|string',
            'objectives.*.activity' => 'required|string',
            'objectives.*.resource' => 'required|string',
            'objectives.*.start_date' => 'required|date',
            'objectives.*.delivery_date' => 'required|date',
            'objectives.*.expected_outcome' => 'required|string',
        ], [
            'objectives.size' => 'All 5 development objectives must be completed.',
            'objectives.*.objective.required' => 'Each objective description is required.',
            'objectives.*.activity.required' => 'Each objective activity is required.',
            'objectives.*.resource.required' => 'Each objective resource is required.',
            'objectives.*.start_date.required' => 'Each objective start date is required.',
            'objectives.*.delivery_date.required' => 'Each objective delivery date is required.',
            'objectives.*.expected_outcome.required' => 'Each expected outcome is required.',
        ]);

        if (! $request->boolean('use_saved_signature') && ! $request->hasFile('signature')) {
            return back()->withErrors(['signature' => 'Manager signature is required.'])->withInput();
        }

        $this->assertNoDuplicateHrSubmission(Development::class, [
            'employee_name' => $validated['employee_name'],
            'department' => $validated['department'],
        ]);

        try {
            DB::beginTransaction();

            $managerSignature = $this->signatures->resolveManagerSignature($request, 'signature', 'signatures/development');
            $candidateSignature = $request->file('candidate_signature')->store('signatures/development/candidate', 'public');

            $development = Development::query()->create([
                'employee_name' => $validated['employee_name'],
                'department' => $validated['department'],
                'line_manager' => $validated['line_manager'],
                'signature_path' => $managerSignature,
                'candidate_signature_path' => $candidateSignature,
                'created_by' => auth()->id(),
            ]);

            foreach ($validated['objectives'] as $rowNumber => $data) {
                $development->objectives()->create(array_merge($data, [
                    'row_number' => $rowNumber + 1,
                    'score' => null,
                ]));
            }

            $progressReview = $this->progressWorkflow->createLinkedProgressReview($development);

            DB::commit();

            return redirect()
                ->route('admin.progress.edit', $progressReview)
                ->with('success', 'Development plan created. Complete IDP scores and tracking in the linked Progress Review.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'An error occurred while saving the IDP: '.$e->getMessage());
        }
    }

    public function show(Development $development): View
    {
        $this->authorizeViewHrRecord($development);
        $development->load(['objectives', 'progressReview']);

        return view('admin.development.show', compact('development'));
    }

    public function edit(Development $development): View
    {
        $this->authorizeEditHrRecord($development);
        $development->load('objectives');
        $departments = $this->departmentsForUser();

        return view('admin.development.edit', compact('development', 'departments'));
    }

    public function update(Request $request, Development $development): RedirectResponse
    {
        $this->authorizeEditHrRecord($development);

        $validated = $request->validate([
            'employee_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'line_manager' => 'required|string|max:255',
            'signature' => 'nullable|image|max:500',
            'candidate_signature' => 'nullable|image|max:500',
            'use_saved_signature' => 'nullable|boolean',
            'objectives' => 'required|array|size:5',
            'objectives.*.objective' => 'required|string',
            'objectives.*.activity' => 'required|string',
            'objectives.*.resource' => 'required|string',
            'objectives.*.start_date' => 'required|date',
            'objectives.*.delivery_date' => 'required|date',
            'objectives.*.expected_outcome' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            if ($request->boolean('use_saved_signature') && auth()->user()?->signature_path) {
                $development->signature_path = auth()->user()->signature_path;
            } elseif ($request->hasFile('signature')) {
                $this->signatures->deletePublicFile($development->signature_path);
                $development->signature_path = $request->file('signature')->store('signatures/development', 'public');
            }

            if ($request->hasFile('candidate_signature')) {
                $this->signatures->deletePublicFile($development->candidate_signature_path);
                $development->candidate_signature_path = $request->file('candidate_signature')->store('signatures/development/candidate', 'public');
            }

            $development->update([
                'employee_name' => $validated['employee_name'],
                'department' => $validated['department'],
                'line_manager' => $validated['line_manager'],
                'signature_path' => $development->signature_path,
                'candidate_signature_path' => $development->candidate_signature_path,
            ]);

            $development->objectives()->delete();

            foreach ($validated['objectives'] as $rowNumber => $data) {
                $development->objectives()->create(array_merge($data, [
                    'row_number' => $rowNumber + 1,
                    'score' => null,
                ]));
            }

            DB::commit();

            return redirect()->route('admin.development.index')->with('success', 'Individual Development Plan updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'An error occurred while updating the IDP: '.$e->getMessage());
        }
    }

    public function destroy(Development $development): RedirectResponse
    {
        $this->authorizeDeleteHrRecord($development);

        $this->signatures->deletePublicFile($development->signature_path);
        $this->signatures->deletePublicFile($development->candidate_signature_path);
        $development->delete();

        return redirect()->route('admin.development.index')->with('success', 'Individual Development Plan deleted successfully.');
    }
}

