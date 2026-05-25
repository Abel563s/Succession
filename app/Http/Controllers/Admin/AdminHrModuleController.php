<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\AuthorizesHrRecords;
use App\Http\Controllers\Controller;
use App\Models\Department;

abstract class AdminHrModuleController extends Controller
{
    use AuthorizesHrRecords;

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Department>
     */
    protected function departmentsForUser(): \Illuminate\Database\Eloquent\Collection
    {
        if (auth()->user()->isAdmin() || auth()->user()->isDceo()) {
            return Department::query()->orderBy('name')->get();
        }

        return Department::query()
            ->where('id', auth()->user()->department_id)
            ->get();
    }
}
