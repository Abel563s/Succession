<?php

namespace App\Services;

use App\Models\Coaching;
use App\Models\CriticalRole;
use App\Models\Development;
use App\Models\LeadershipAssessment;
use App\Models\LeadershipCompetencyRating;
use App\Models\Mentor;
use App\Models\NineBoxGrid;
use App\Models\ProgressIdpObjective;
use App\Models\ProgressReview;
use App\Models\ProgressTrackingItem;
use App\Models\Succession;
use App\Models\SuccessionDashboard;
use App\Models\Training;
use App\Models\Transition;
use App\Models\TransitionItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class HrReportService
{
    /**
     * @var array<string, array{model: class-string<Model>, label: string, route: string, department_column: string}>
     */
    protected array $moduleRegistry = [
        'critical_roles' => [
            'model' => CriticalRole::class,
            'label' => 'Critical Roles',
            'route' => 'admin.critical-roles.show',
            'department_column' => 'department',
        ],
        'successions' => [
            'model' => Succession::class,
            'label' => 'Succession Planning',
            'route' => 'admin.successions.show',
            'department_column' => 'department',
        ],
        'nine_box' => [
            'model' => NineBoxGrid::class,
            'label' => '9-Box Grid',
            'route' => 'admin.nine-box.show',
            'department_column' => 'department',
        ],
        'development' => [
            'model' => Development::class,
            'label' => 'Development (IDP)',
            'route' => 'admin.development.show',
            'department_column' => 'department',
        ],
        'training' => [
            'model' => Training::class,
            'label' => 'Training',
            'route' => 'admin.training.show',
            'department_column' => 'department',
        ],
        'mentor' => [
            'model' => Mentor::class,
            'label' => 'Mentor',
            'route' => 'admin.mentor.show',
            'department_column' => 'department',
        ],
        'coaching' => [
            'model' => Coaching::class,
            'label' => 'Coaching',
            'route' => 'admin.coaching.show',
            'department_column' => 'department',
        ],
        'progress' => [
            'model' => ProgressReview::class,
            'label' => 'Progress Reviews',
            'route' => 'admin.progress.show',
            'department_column' => 'department',
        ],
        'sd' => [
            'model' => SuccessionDashboard::class,
            'label' => 'Succession Dashboard',
            'route' => 'admin.sd.show',
            'department_column' => 'department',
        ],
        'leadership' => [
            'model' => LeadershipAssessment::class,
            'label' => 'Leadership Assessment',
            'route' => 'admin.leadership.show',
            'department_column' => 'department',
        ],
        'transition' => [
            'model' => Transition::class,
            'label' => 'Transition Plans',
            'route' => 'admin.transition.show',
            'department_column' => 'department',
        ],
    ];

    /**
     * @return array<string, mixed>
     */
    public function generate(?string $department = null, ?string $dateFrom = null, ?string $dateTo = null): array
    {
        $from = $dateFrom ? Carbon::parse($dateFrom)->startOfDay() : null;
        $to = $dateTo ? Carbon::parse($dateTo)->endOfDay() : null;

        return [
            'filters' => [
                'department' => $department,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            ],
            'generated_at' => now(),
            'summary' => $this->executiveSummary($department, $from, $to),
            'approval' => $this->approvalBreakdown($department, $from, $to),
            'departments' => $this->departmentBreakdown($department, $from, $to),
            'monthly_trend' => $this->monthlyTrend($department, $from, $to),
            'critical_roles' => $this->criticalRolesReport($department, $from, $to),
            'successions' => $this->successionsReport($department, $from, $to),
            'nine_box' => $this->nineBoxReport($department, $from, $to),
            'development' => $this->developmentReport($department, $from, $to),
            'training' => $this->trainingReport($department, $from, $to),
            'mentor' => $this->mentorReport($department, $from, $to),
            'coaching' => $this->coachingReport($department, $from, $to),
            'progress' => $this->progressReport($department, $from, $to),
            'succession_dashboard' => $this->successionDashboardReport($department, $from, $to),
            'leadership' => $this->leadershipReport($department, $from, $to),
            'transitions' => $this->transitionsReport($department, $from, $to),
            'risks' => $this->riskAlerts($department, $from, $to),
            'managers' => $this->managerSignatureStatus(),
        ];
    }

    /**
     * @return Collection<int, string>
     */
    public function availableDepartments(): Collection
    {
        $departments = collect();

        foreach ($this->moduleRegistry as $config) {
            /** @var class-string<Model> $model */
            $model = $config['model'];
            $column = $config['department_column'];
            $departments = $departments->merge(
                $model::query()->whereNotNull($column)->distinct()->orderBy($column)->pluck($column)
            );
        }

        return $departments->filter()->unique()->sort()->values();
    }

    /**
     * @param  class-string<Model>  $modelClass
     */
    protected function scopedQuery(string $modelClass, string $departmentColumn, ?string $department, ?Carbon $from, ?Carbon $to): Builder
    {
        /** @var Builder $query */
        $query = $modelClass::query();

        if ($department) {
            $query->where($departmentColumn, $department);
        }

        if ($from) {
            $query->where('created_at', '>=', $from);
        }

        if ($to) {
            $query->where('created_at', '<=', $to);
        }

        return $query;
    }

    /**
     * @return array<string, mixed>
     */
    protected function executiveSummary(?string $department, ?Carbon $from, ?Carbon $to): array
    {
        $moduleTotals = [];
        $totalRecords = 0;
        $pendingApprovals = 0;

        foreach ($this->moduleRegistry as $key => $config) {
            $query = $this->scopedQuery($config['model'], $config['department_column'], $department, $from, $to);
            $count = (clone $query)->count();
            $pending = (clone $query)->where('approval_status', 'Pending')->count();

            $moduleTotals[$key] = [
                'label' => $config['label'],
                'count' => $count,
                'pending' => $pending,
            ];
            $totalRecords += $count;
            $pendingApprovals += $pending;
        }

        $idpObjectives = ProgressIdpObjective::query()
            ->when($department, fn ($q) => $q->whereHas('progressReview', fn ($pr) => $pr->where('department', $department)))
            ->when($from, fn ($q) => $q->where('created_at', '>=', $from))
            ->when($to, fn ($q) => $q->where('created_at', '<=', $to))
            ->count();

        $transitionItems = TransitionItem::query()
            ->when($department, fn ($q) => $q->whereHas('transition', fn ($t) => $t->where('department', $department)))
            ->when($from, fn ($q) => $q->where('created_at', '>=', $from))
            ->when($to, fn ($q) => $q->where('created_at', '<=', $to))
            ->count();

        return [
            'total_records' => $totalRecords,
            'pending_approvals' => $pendingApprovals,
            'module_totals' => $moduleTotals,
            'idp_objectives_tracked' => $idpObjectives,
            'transition_handovers' => $transitionItems,
            'linked_development_progress' => $this->scopedQuery(Development::class, 'department', $department, $from, $to)
                ->whereHas('progressReview')->count(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function approvalBreakdown(?string $department, ?Carbon $from, ?Carbon $to): array
    {
        $rows = [];

        foreach ($this->moduleRegistry as $key => $config) {
            $base = $this->scopedQuery($config['model'], $config['department_column'], $department, $from, $to);

            $rows[] = [
                'module' => $config['label'],
                'key' => $key,
                'pending' => (clone $base)->where('approval_status', 'Pending')->count(),
                'approved' => (clone $base)->where('approval_status', 'Approved')->count(),
                'rejected' => (clone $base)->where('approval_status', 'Rejected')->count(),
                'total' => (clone $base)->count(),
            ];
        }

        return ['modules' => $rows];
    }

    /**
     * @return array<string, mixed>
     */
    protected function departmentBreakdown(?string $department, ?Carbon $from, ?Carbon $to): array
    {
        if ($department) {
            return ['rows' => []];
        }

        $deptMap = [];

        foreach ($this->moduleRegistry as $config) {
            $counts = $this->scopedQuery($config['model'], $config['department_column'], null, $from, $to)
                ->selectRaw('department, COUNT(*) as total')
                ->groupBy('department')
                ->pluck('total', 'department');

            foreach ($counts as $dept => $total) {
                if (! $dept) {
                    continue;
                }
                $deptMap[$dept] = ($deptMap[$dept] ?? 0) + (int) $total;
            }
        }

        arsort($deptMap);

        $rows = collect($deptMap)->map(fn ($total, $dept) => [
            'department' => $dept,
            'total' => $total,
        ])->values()->all();

        return ['rows' => $rows];
    }

    /**
     * @return array<string, mixed>
     */
    protected function monthlyTrend(?string $department, ?Carbon $from, ?Carbon $to): array
    {
        $months = [];
        $start = ($from ?? now()->subMonths(11))->copy()->startOfMonth();
        $end = ($to ?? now())->copy()->endOfMonth();

        while ($start <= $end) {
            $months[$start->format('Y-m')] = [
                'label' => $start->format('M Y'),
                'total' => 0,
            ];
            $start->addMonth();
        }

        foreach ($this->moduleRegistry as $config) {
            $createdAts = $this->scopedQuery($config['model'], $config['department_column'], $department, $from, $to)
                ->pluck('created_at');

            foreach ($createdAts as $createdAt) {
                if (! $createdAt) {
                    continue;
                }
                $month = Carbon::parse($createdAt)->format('Y-m');
                if (isset($months[$month])) {
                    $months[$month]['total']++;
                }
            }
        }

        return ['months' => array_values($months)];
    }

    /**
     * @return array<string, mixed>
     */
    protected function criticalRolesReport(?string $department, ?Carbon $from, ?Carbon $to): array
    {
        $query = $this->scopedQuery(CriticalRole::class, 'department', $department, $from, $to);

        $records = (clone $query)->latest()->get();

        return [
            'total' => $records->count(),
            'vacancy_risk' => $records->groupBy('vacancy_risk')->map->count()->all(),
            'position_impact' => $records->groupBy('position_impact')->map->count()->all(),
            'without_successors' => $records->filter(fn ($r) => ! $r->successor_1_name && ! $r->successor_2_name && ! $r->successor_3_name)->count(),
            'records' => $records->take(50),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function successionsReport(?string $department, ?Carbon $from, ?Carbon $to): array
    {
        $records = $this->scopedQuery(Succession::class, 'department', $department, $from, $to)->latest()->get();

        $avgIpg = $records
            ->map(fn ($r) => is_numeric(data_get($r, 'ipg_score')) ? (float) data_get($r, 'ipg_score') : null)
            ->filter()
            ->avg();

        return [
            'total' => $records->count(),
            'readiness' => $records->groupBy('readiness_level')->map->count()->all(),
            'avg_ipg' => round($avgIpg ?? 0, 1),
            'records' => $records->take(50),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function nineBoxReport(?string $department, ?Carbon $from, ?Carbon $to): array
    {
        $records = $this->scopedQuery(NineBoxGrid::class, 'department', $department, $from, $to)->latest()->get();

        return [
            'total' => $records->count(),
            'grid_positions' => $records->groupBy('grid_position')->map->count()->all(),
            'performance' => $records->groupBy('performance_level')->map->count()->all(),
            'potential' => $records->groupBy('potential_level')->map->count()->all(),
            'records' => $records->take(50),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function developmentReport(?string $department, ?Carbon $from, ?Carbon $to): array
    {
        $records = $this->scopedQuery(Development::class, 'department', $department, $from, $to)
            ->with(['objectives', 'progressReview'])
            ->latest()
            ->get();

        $objectiveCount = $records->sum(fn ($d) => $d->objectives->count());

        return [
            'total' => $records->count(),
            'total_objectives' => $objectiveCount,
            'with_progress_link' => $records->filter(fn ($d) => $d->progressReview)->count(),
            'records' => $records->take(50),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function trainingReport(?string $department, ?Carbon $from, ?Carbon $to): array
    {
        $records = $this->scopedQuery(Training::class, 'department', $department, $from, $to)->latest()->get();

        $scores = $records->flatMap(fn ($r) => array_filter([$r->score_1, $r->score_2, $r->score_3], fn ($s) => $s !== null && $s !== ''));

        return [
            'total' => $records->count(),
            'avg_goal_scores' => $scores->count() > 0 ? round($scores->avg(fn ($s) => (float) $s), 1) : null,
            'records' => $records->take(50),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function mentorReport(?string $department, ?Carbon $from, ?Carbon $to): array
    {
        $records = $this->scopedQuery(Mentor::class, 'department', $department, $from, $to)->latest()->get();

        return [
            'total' => $records->count(),
            'records' => $records->take(50),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function coachingReport(?string $department, ?Carbon $from, ?Carbon $to): array
    {
        $records = $this->scopedQuery(Coaching::class, 'department', $department, $from, $to)->latest()->get();

        return [
            'total' => $records->count(),
            'by_department' => $records->groupBy('department')->map->count()->all(),
            'records' => $records->take(50),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function progressReport(?string $department, ?Carbon $from, ?Carbon $to): array
    {
        $records = $this->scopedQuery(ProgressReview::class, 'department', $department, $from, $to)
            ->with(['idpObjectives', 'trackingItems', 'development'])
            ->latest()
            ->get();

        $scoredObjectives = ProgressIdpObjective::query()
            ->whereIn('progress_review_id', $records->pluck('id'))
            ->whereNotNull('score')
            ->where('score', '!=', '')
            ->count();

        return [
            'total' => $records->count(),
            'status' => $records->groupBy('status')->map->count()->all(),
            'tracking_entries' => ProgressTrackingItem::query()
                ->whereIn('progress_review_id', $records->pluck('id'))
                ->count(),
            'idp_objectives_scored' => $scoredObjectives,
            'records' => $records->take(50),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function successionDashboardReport(?string $department, ?Carbon $from, ?Carbon $to): array
    {
        $dashboards = $this->scopedQuery(SuccessionDashboard::class, 'department', $department, $from, $to)
            ->with('items')
            ->latest()
            ->get();

        $items = $dashboards->flatMap->items;

        return [
            'total_dashboards' => $dashboards->count(),
            'total_positions' => $items->count(),
            'readiness' => $items->groupBy('readiness_rating')->map->count()->all(),
            'dashboards' => $dashboards->take(20),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function leadershipReport(?string $department, ?Carbon $from, ?Carbon $to): array
    {
        $records = $this->scopedQuery(LeadershipAssessment::class, 'department', $department, $from, $to)
            ->with('ratings')
            ->latest()
            ->get();

        $competencyAvg = LeadershipCompetencyRating::query()
            ->whereIn('leadership_assessment_id', $records->pluck('id'))
            ->selectRaw('competency_name, AVG(rating) as avg_rating, COUNT(*) as count')
            ->groupBy('competency_name')
            ->orderByDesc('avg_rating')
            ->get();

        return [
            'total' => $records->count(),
            'status' => $records->groupBy('status')->map->count()->all(),
            'avg_overall_score' => round($records->avg('overall_score') ?? 0, 1),
            'competency_averages' => $competencyAvg,
            'records' => $records->take(50),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function transitionsReport(?string $department, ?Carbon $from, ?Carbon $to): array
    {
        $plans = $this->scopedQuery(Transition::class, 'department', $department, $from, $to)
            ->with('items')
            ->latest()
            ->get();

        $items = $plans->flatMap(function ($plan) {
            return $plan->items->map(function ($item) use ($plan) {
                $item->setRelation('transition', $plan);

                return $item;
            });
        });

        return [
            'total_plans' => $plans->count(),
            'status' => $plans->groupBy('status')->map->count()->all(),
            'upcoming' => $items->filter(fn ($i) => $i->transition_date && Carbon::parse($i->transition_date)->isFuture())->count(),
            'overdue' => $items->filter(fn ($i) => $i->transition_date && Carbon::parse($i->transition_date)->isPast())->count(),
            'items' => $items->sortBy('transition_date')->take(50)->values(),
            'plans' => $plans->take(20),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function riskAlerts(?string $department, ?Carbon $from, ?Carbon $to): array
    {
        $alerts = [];

        $highRiskRoles = $this->scopedQuery(CriticalRole::class, 'department', $department, $from, $to)
            ->where('vacancy_risk', 'High')
            ->count();
        if ($highRiskRoles > 0) {
            $alerts[] = ['level' => 'high', 'message' => "{$highRiskRoles} critical role(s) marked High vacancy risk."];
        }

        $noSuccessors = $this->scopedQuery(CriticalRole::class, 'department', $department, $from, $to)
            ->whereNull('successor_1_name')
            ->whereNull('successor_2_name')
            ->whereNull('successor_3_name')
            ->count();
        if ($noSuccessors > 0) {
            $alerts[] = ['level' => 'medium', 'message' => "{$noSuccessors} critical role(s) have no named successors."];
        }

        foreach ($this->moduleRegistry as $config) {
            $pending = $this->scopedQuery($config['model'], $config['department_column'], $department, $from, $to)
                ->where('approval_status', 'Pending')
                ->count();
            if ($pending > 0) {
                $alerts[] = ['level' => 'info', 'message' => "{$pending} pending {$config['label']} awaiting approval."];
            }
        }

        $upcomingTransitions = TransitionItem::query()
            ->when($department, fn ($q) => $q->whereHas('transition', fn ($t) => $t->where('department', $department)))
            ->when($from, fn ($q) => $q->where('created_at', '>=', $from))
            ->when($to, fn ($q) => $q->where('created_at', '<=', $to))
            ->whereBetween('transition_date', [now(), now()->addDays(30)])
            ->count();
        if ($upcomingTransitions > 0) {
            $alerts[] = ['level' => 'info', 'message' => "{$upcomingTransitions} transition handover(s) due within 30 days."];
        }

        return ['items' => $alerts];
    }

    /**
     * @return array<string, mixed>
     */
    protected function managerSignatureStatus(): array
    {
        $managers = User::query()->where('role', 'manager')->orderBy('name')->get();

        return [
            'total' => $managers->count(),
            'with_signature' => $managers->whereNotNull('signature_path')->count(),
            'without_signature' => $managers->whereNull('signature_path')->count(),
            'managers' => $managers,
        ];
    }

    public function moduleRegistry(): array
    {
        return $this->moduleRegistry;
    }
}
