<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Services\HrReportService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends AdminHrModuleController
{
    public function __construct(
        protected HrReportService $reports,
    ) {}

    public function index(Request $request): View
    {
        $department = $request->filled('department') ? $request->string('department')->toString() : null;

        if (! auth()->user()->isAdmin() && ! auth()->user()->isDceo()) {
            $department = $this->hrDepartmentName(auth()->user());
        }

        $report = $this->reports->generate(
            $department,
            $request->input('date_from'),
            $request->input('date_to'),
        );

        $departments = (auth()->user()->isAdmin() || auth()->user()->isDceo())
            ? $this->reports->availableDepartments()
            : Department::query()->where('id', auth()->user()->department_id)->pluck('name');

        return view('admin.reports.index', [
            'report' => $report,
            'departments' => $departments,
            'filters' => $request->only(['department', 'date_from', 'date_to']),
        ]);
    }
}
