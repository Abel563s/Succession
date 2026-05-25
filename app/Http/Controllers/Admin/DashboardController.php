<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $isAdmin = auth()->user()->isAdmin() || auth()->user()->isDceo();
        $deptName = (!$isAdmin && auth()->user()->department) ? auth()->user()->department->name : null;

        // Helper closures for query scope
        $applyDept = function($query) use ($isAdmin, $deptName) {
            if (!$isAdmin) {
                if ($deptName) {
                    $query->where('department', $deptName);
                } else {
                    $query->whereRaw('1 = 0');
                }
            }
            return $query;
        };

        // 1. Critical Roles Stats
        $criticalRolesCount = $applyDept(\App\Models\CriticalRole::query())->count();
        $vacantCriticalRoles = $applyDept(\App\Models\CriticalRole::query())
            ->where(function($q) {
                $q->where('position_status', 'like', '%Vacant%')
                  ->orWhere('position_status', 'like', '%Open%');
            })
            ->count();
        $rolesWithoutSuccessors = $applyDept(\App\Models\CriticalRole::query())
            ->whereNull('successor_1_name')
            ->whereNull('successor_2_name')
            ->count();

        // 2. Succession Dashboard Stats
        $successionPlansCount = $applyDept(\App\Models\Succession::query())->count();
        $highReadinessCandidates = $applyDept(\App\Models\Succession::query())
            ->whereIn('readiness_level', ['High', 'Ready Now', 'Ready in 1 Year'])
            ->count();
        $rolesRequiringSuccessors = $applyDept(\App\Models\CriticalRole::query())
            ->whereNull('successor_1_name')
            ->count();

        // 3. Leadership Stats
        $leadershipCount = $applyDept(\App\Models\LeadershipAssessment::query())->count();
        $leadershipCompleted = $applyDept(\App\Models\LeadershipAssessment::query())
            ->where('status', 'Completed')
            ->count();
        $avgLeadershipScore = round($applyDept(\App\Models\LeadershipAssessment::query())->avg('overall_score') ?? 0, 1);

        // 4. Transition Stats
        $upcomingTransitionsQuery = \App\Models\TransitionItem::whereDate('transition_date', '>=', now());
        if (!$isAdmin) {
            if ($deptName) {
                $upcomingTransitionsQuery->whereHas('transition', function($q) use ($deptName) {
                    $q->where('department', $deptName);
                });
            } else {
                $upcomingTransitionsQuery->whereRaw('1 = 0');
            }
        }
        $upcomingTransitions = $upcomingTransitionsQuery->count();
        $completedTransitions = $applyDept(\App\Models\Transition::query())->where('status', 'Completed')->count();
        $delayedTransitions = $applyDept(\App\Models\Transition::query())->where('status', 'Delayed')->count();

        // 5. Progress Reviews Stats
        $progressCount = $applyDept(\App\Models\ProgressReview::query())->count();
        $progressPending = $applyDept(\App\Models\ProgressReview::query())->where('status', 'Pending')->count();
        $progressCompleted = $applyDept(\App\Models\ProgressReview::query())->where('status', 'Completed')->count();

        // 6. Mentor & Coaching Stats
        $mentorCount = $applyDept(\App\Models\Mentor::query())->count();
        $coachingCount = $applyDept(\App\Models\Coaching::query())->count();

        // 7. Recent Lists
        $recentCriticalRoles = $applyDept(\App\Models\CriticalRole::query())->latest()->take(5)->get();
        $recentLeadership = $applyDept(\App\Models\LeadershipAssessment::query())->latest()->take(5)->get();
        $recentProgress = $applyDept(\App\Models\ProgressReview::query())->latest()->take(5)->get();
        $recentTransitions = $applyDept(\App\Models\Transition::with('items'))->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'criticalRolesCount', 'vacantCriticalRoles', 'rolesWithoutSuccessors',
            'successionPlansCount', 'highReadinessCandidates', 'rolesRequiringSuccessors',
            'leadershipCount', 'leadershipCompleted', 'avgLeadershipScore',
            'upcomingTransitions', 'completedTransitions', 'delayedTransitions',
            'progressCount', 'progressPending', 'progressCompleted',
            'mentorCount', 'coachingCount',
            'recentCriticalRoles', 'recentLeadership', 'recentProgress', 'recentTransitions'
        ));
    }
}
