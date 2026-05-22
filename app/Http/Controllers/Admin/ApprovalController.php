<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;

class ApprovalController extends Controller
{
    /**
     * @var array<string, class-string<Model>>
     */
    protected array $models = [
        'critical-roles' => \App\Models\CriticalRole::class,
        'successions' => \App\Models\Succession::class,
        'nine-box' => \App\Models\NineBoxGrid::class,
        'development' => \App\Models\Development::class,
        'training' => \App\Models\Training::class,
        'mentor' => \App\Models\Mentor::class,
        'coaching' => \App\Models\Coaching::class,
        'progress' => \App\Models\ProgressReview::class,
        'sd' => \App\Models\SuccessionDashboard::class,
        'leadership' => \App\Models\LeadershipAssessment::class,
        'transition' => \App\Models\Transition::class,
    ];

    public function approve(string $module, int $id): RedirectResponse
    {
        $record = $this->resolveRecord($module, $id);
        $record->update(['approval_status' => 'Approved']);

        return back()->with('success', 'Record approved successfully.');
    }

    public function reject(string $module, int $id): RedirectResponse
    {
        $record = $this->resolveRecord($module, $id);
        $record->update(['approval_status' => 'Rejected']);

        return back()->with('success', 'Record rejected successfully.');
    }

    protected function resolveRecord(string $module, int $id): Model
    {
        if (! isset($this->models[$module])) {
            abort(404, 'Module not found.');
        }

        /** @var class-string<Model> $modelClass */
        $modelClass = $this->models[$module];

        return $modelClass::query()->findOrFail($id);
    }
}
