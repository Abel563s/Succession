@php
    $r = $report;
    $moduleRoutes = [
        'critical_roles' => 'admin.critical-roles.show',
        'successions' => 'admin.successions.show',
        'nine_box' => 'admin.nine-box.show',
        'development' => 'admin.development.show',
        'training' => 'admin.training.show',
        'mentor' => 'admin.mentor.show',
        'coaching' => 'admin.coaching.show',
        'progress' => 'admin.progress.show',
        'sd' => 'admin.sd.show',
        'leadership' => 'admin.leadership.show',
        'transition' => 'admin.transition.show',
    ];
@endphp
<x-app-layout>
    <div class="max-w-[1600px] mx-auto space-y-8 pb-16 font-inter report-page" id="hr-report">
        <!-- Header -->
        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6 border-b border-slate-200 pb-6 no-print">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#111111] to-[#00333B] text-white flex items-center justify-center shadow-lg shadow-[#111111]/20">
                    <i data-lucide="file-bar-chart" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">HR Succession & Development Report</h1>
                    <p class="text-xs text-slate-500 font-medium mt-1">
                        Generated {{ $r['generated_at']->format('M d, Y h:i A') }}
                        @if($r['filters']['department'])
                            &bull; Department: <span class="font-bold text-[#111111]">{{ $r['filters']['department'] }}</span>
                        @else
                            &bull; <span class="font-bold">Organization-wide</span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap gap-3">
                <button type="button" onclick="window.print()"
                        class="bg-white border border-slate-200 text-slate-700 px-5 py-2.5 rounded-xl font-bold text-xs flex items-center gap-2 hover:bg-slate-50 transition-all shadow-sm">
                    <i data-lucide="printer" class="w-4 h-4"></i>
                    Print Report
                </button>
            </div>
        </div>

        <!-- Filters -->
        <form method="GET" action="{{ route('admin.reports.index') }}" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm no-print">
            <div class="flex flex-wrap items-end gap-4">
                @if(auth()->user()->isAdmin())
                    <div class="w-56">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5 block">Department</label>
                        <select name="department" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700">
                            <option value="">All Departments</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}" @selected(($filters['department'] ?? '') === $dept)>{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="w-44">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5 block">From</label>
                    <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700">
                </div>
                <div class="w-44">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5 block">To</label>
                    <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700">
                </div>
                <button type="submit" class="bg-[#111111] text-white px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-[#00333B] transition-all">
                    Apply Filters
                </button>
                <a href="{{ route('admin.reports.index') }}" class="text-xs font-bold text-slate-400 hover:text-rose-500 uppercase tracking-widest py-2.5">Reset</a>
            </div>
        </form>

        <!-- Section nav -->
        <nav class="no-print flex flex-wrap gap-2 p-4 bg-slate-50 rounded-2xl border border-slate-100">
            @foreach(['summary' => 'Summary', 'approval' => 'Approvals', 'critical' => 'Critical Roles', 'succession' => 'Succession', 'ninebox' => '9-Box', 'development' => 'Development', 'training' => 'Training', 'mentor' => 'Mentor', 'coaching' => 'Coaching', 'progress' => 'Progress', 'sd' => 'SD', 'leadership' => 'Leadership', 'transition' => 'Transitions', 'risks' => 'Risks'] as $id => $label)
                <a href="#section-{{ $id }}" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-[10px] font-black uppercase tracking-wider text-slate-500 hover:text-[#111111] hover:border-[#D4AF37]/30 transition-all">{{ $label }}</a>
            @endforeach
        </nav>

        <!-- 1. Executive Summary -->
        <section id="section-summary" class="report-section space-y-6">
            <h2 class="text-lg font-black text-slate-900 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-[#111111] text-white flex items-center justify-center text-xs">1</span>
                Executive Summary
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Total Records</p>
                    <p class="text-3xl font-black text-slate-900 mt-2">{{ $r['summary']['total_records'] }}</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-amber-100 shadow-sm">
                    <p class="text-[10px] font-black uppercase text-amber-600 tracking-widest">Pending Approval</p>
                    <p class="text-3xl font-black text-amber-600 mt-2">{{ $r['summary']['pending_approvals'] }}</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">IDP Objectives</p>
                    <p class="text-3xl font-black text-[#111111] mt-2">{{ $r['summary']['idp_objectives_tracked'] }}</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Transition Handovers</p>
                    <p class="text-3xl font-black text-slate-900 mt-2">{{ $r['summary']['transition_handovers'] }}</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Dev → Progress Linked</p>
                    <p class="text-3xl font-black text-emerald-600 mt-2">{{ $r['summary']['linked_development_progress'] }}</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Managers w/ Signature</p>
                    <p class="text-3xl font-black text-slate-900 mt-2">{{ $r['managers']['with_signature'] }}/{{ $r['managers']['total'] }}</p>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-3">
                @foreach($r['summary']['module_totals'] as $key => $mod)
                    <div class="bg-white px-4 py-3 rounded-xl border border-slate-100">
                        <p class="text-[9px] font-black uppercase text-slate-400 tracking-tight">{{ $mod['label'] }}</p>
                        <p class="text-xl font-black text-slate-900">{{ $mod['count'] }}</p>
                        @if($mod['pending'] > 0)
                            <p class="text-[9px] font-bold text-amber-600">{{ $mod['pending'] }} pending</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>

        <!-- 2. Approval Pipeline -->
        <section id="section-approval" class="report-section bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-lg font-black text-slate-900">Approval Pipeline</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#111111] to-[#00333B] text-white text-[10px] font-black uppercase tracking-widest">
                            <th class="px-6 py-4 text-left">Module</th>
                            <th class="px-4 py-4 text-center">Total</th>
                            <th class="px-4 py-4 text-center">Pending</th>
                            <th class="px-4 py-4 text-center">Approved</th>
                            <th class="px-4 py-4 text-center">Rejected</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($r['approval']['modules'] as $row)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-6 py-4 font-bold text-slate-800">{{ $row['module'] }}</td>
                                <td class="px-4 py-4 text-center font-black">{{ $row['total'] }}</td>
                                <td class="px-4 py-4 text-center"><span class="text-amber-600 font-bold">{{ $row['pending'] }}</span></td>
                                <td class="px-4 py-4 text-center"><span class="text-emerald-600 font-bold">{{ $row['approved'] }}</span></td>
                                <td class="px-4 py-4 text-center"><span class="text-rose-600 font-bold">{{ $row['rejected'] }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        @if(count($r['departments']['rows']) > 0)
            <section class="report-section bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
                <h2 class="text-lg font-black text-slate-900 mb-4">Records by Department</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    @foreach($r['departments']['rows'] as $row)
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <p class="text-[10px] font-black uppercase text-slate-400 truncate" title="{{ $row['department'] }}">{{ $row['department'] }}</p>
                            <p class="text-2xl font-black text-[#111111]">{{ $row['total'] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if(count($r['monthly_trend']['months']) > 0)
            <section class="report-section bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
                <h2 class="text-lg font-black text-slate-900 mb-4">Monthly Activity Trend</h2>
                <div class="flex items-end gap-2 h-40">
                    @php $maxTrend = max(1, collect($r['monthly_trend']['months'])->max('total')); @endphp
                    @foreach($r['monthly_trend']['months'] as $month)
                        <div class="flex-1 flex flex-col items-center gap-1 min-w-0">
                            <div class="w-full bg-[#D4AF37]/20 rounded-t-lg flex items-end justify-center" style="height: {{ max(4, ($month['total'] / $maxTrend) * 120) }}px">
                                <div class="w-full max-w-[32px] bg-[#111111] rounded-t-lg" style="height: 100%"></div>
                            </div>
                            <span class="text-[8px] font-black text-slate-400 uppercase truncate w-full text-center">{{ $month['label'] }}</span>
                            <span class="text-[10px] font-bold text-slate-700">{{ $month['total'] }}</span>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Risk Alerts -->
        <section id="section-risks" class="report-section space-y-4">
            <h2 class="text-lg font-black text-slate-900">Risk & Action Alerts</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($r['risks']['items'] as $alert)
                    @php
                        $colors = match($alert['level']) {
                            'high' => 'border-rose-200 bg-rose-50 text-rose-800',
                            'medium' => 'border-amber-200 bg-amber-50 text-amber-800',
                            default => 'border-sky-200 bg-sky-50 text-sky-800',
                        };
                    @endphp
                    <div class="p-4 rounded-2xl border {{ $colors }} text-sm font-medium flex items-start gap-3">
                        <i data-lucide="alert-triangle" class="w-5 h-5 shrink-0"></i>
                        {{ $alert['message'] }}
                    </div>
                @empty
                    <p class="text-slate-500 text-sm col-span-2">No risk alerts for the selected filters.</p>
                @endforelse
            </div>
        </section>

        <!-- Critical Roles Detail -->
        <section id="section-critical" class="report-section bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex flex-wrap items-center justify-between gap-4">
                <h2 class="text-lg font-black text-slate-900">Critical Roles ({{ $r['critical_roles']['total'] }})</h2>
                <div class="flex gap-4 text-[10px] font-bold text-slate-500">
                    <span>No successors: <strong class="text-rose-600">{{ $r['critical_roles']['without_successors'] }}</strong></span>
                    @foreach($r['critical_roles']['vacancy_risk'] as $risk => $count)
                        <span>{{ $risk }} risk: <strong>{{ $count }}</strong></span>
                    @endforeach
                </div>
            </div>
            <div class="overflow-x-auto max-h-[480px]">
                <table class="w-full text-xs">
                    <thead class="sticky top-0 bg-slate-50 text-[10px] font-black uppercase text-slate-400">
                        <tr>
                            <th class="px-4 py-3 text-left">Employee</th>
                            <th class="px-4 py-3 text-left">Role</th>
                            <th class="px-4 py-3">Dept</th>
                            <th class="px-4 py-3">Risk</th>
                            <th class="px-4 py-3">Impact</th>
                            <th class="px-4 py-3">Successors</th>
                            <th class="px-4 py-3">Approval</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($r['critical_roles']['records'] as $record)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-4 py-3 font-bold text-slate-800">
                                    <a href="{{ route('admin.critical-roles.show', $record) }}" class="text-[#111111] hover:underline">{{ $record->employee_name }}</a>
                                </td>
                                <td class="px-4 py-3">{{ $record->critical_role }}</td>
                                <td class="px-4 py-3">{{ $record->department }}</td>
                                <td class="px-4 py-3">{{ $record->vacancy_risk }}</td>
                                <td class="px-4 py-3">{{ $record->position_impact }}</td>
                                <td class="px-4 py-3">{{ collect([$record->successor_1_name, $record->successor_2_name, $record->successor_3_name])->filter()->count() }}</td>
                                <td class="px-4 py-3"><x-hr-approval-badge :status="$record->approval_status" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Succession -->
        <section id="section-succession" class="report-section bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100">
                <h2 class="text-lg font-black text-slate-900">Succession Planning ({{ $r['successions']['total'] }}) — Avg IPG: {{ $r['successions']['avg_ipg'] }}</h2>
            </div>
            <div class="overflow-x-auto max-h-[400px]">
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 text-[10px] font-black uppercase text-slate-400">
                        <tr>
                            <th class="px-4 py-3 text-left">Candidate</th>
                            <th class="px-4 py-3">Dept</th>
                            <th class="px-4 py-3">Target Role</th>
                            <th class="px-4 py-3">Readiness</th>
                            <th class="px-4 py-3">IPG</th>
                            <th class="px-4 py-3">Approval</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($r['successions']['records'] as $record)
                            <tr>
                                <td class="px-4 py-3 font-bold"><a href="{{ route('admin.successions.show', $record) }}" class="text-[#111111]">{{ $record->candidate_name }}</a></td>
                                <td class="px-4 py-3">{{ $record->department }}</td>
                                <td class="px-4 py-3">{{ $record->target_role }}</td>
                                <td class="px-4 py-3">{{ $record->readiness_level }}</td>
                                <td class="px-4 py-3 font-black">{{ $record->ipg_score }}</td>
                                <td class="px-4 py-3"><x-hr-approval-badge :status="$record->approval_status" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 9-Box -->
        <section id="section-ninebox" class="report-section bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100">
                <h2 class="text-lg font-black text-slate-900">9-Box Grid ({{ $r['nine_box']['total'] }})</h2>
            </div>
            <div class="overflow-x-auto max-h-[360px]">
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 text-[10px] font-black uppercase text-slate-400">
                        <tr>
                            <th class="px-4 py-3 text-left">Candidate</th>
                            <th class="px-4 py-3">Dept</th>
                            <th class="px-4 py-3">Grid</th>
                            <th class="px-4 py-3">Performance</th>
                            <th class="px-4 py-3">Potential</th>
                            <th class="px-4 py-3">Approval</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($r['nine_box']['records'] as $record)
                            <tr>
                                <td class="px-4 py-3 font-bold"><a href="{{ route('admin.nine-box.show', $record) }}" class="text-[#111111]">{{ $record->candidate_name }}</a></td>
                                <td class="px-4 py-3">{{ $record->department }}</td>
                                <td class="px-4 py-3 font-black">{{ $record->grid_position }}</td>
                                <td class="px-4 py-3">{{ $record->performance_level }}</td>
                                <td class="px-4 py-3">{{ $record->potential_level }}</td>
                                <td class="px-4 py-3"><x-hr-approval-badge :status="$record->approval_status" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Development -->
        <section id="section-development" class="report-section bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100">
                <h2 class="text-lg font-black text-slate-900">Development / IDP ({{ $r['development']['total'] }} plans, {{ $r['development']['total_objectives'] }} objectives)</h2>
            </div>
            <div class="overflow-x-auto max-h-[360px]">
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 text-[10px] font-black uppercase text-slate-400">
                        <tr>
                            <th class="px-4 py-3 text-left">Employee</th>
                            <th class="px-4 py-3">Dept</th>
                            <th class="px-4 py-3">Manager</th>
                            <th class="px-4 py-3 text-center">Objectives</th>
                            <th class="px-4 py-3 text-center">Progress Link</th>
                            <th class="px-4 py-3">Approval</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($r['development']['records'] as $record)
                            <tr>
                                <td class="px-4 py-3 font-bold"><a href="{{ route('admin.development.show', $record) }}" class="text-[#111111]">{{ $record->employee_name }}</a></td>
                                <td class="px-4 py-3">{{ $record->department }}</td>
                                <td class="px-4 py-3">{{ $record->line_manager }}</td>
                                <td class="px-4 py-3 text-center font-black">{{ $record->objectives->count() }}</td>
                                <td class="px-4 py-3 text-center">{{ $record->progressReview ? 'Yes' : 'No' }}</td>
                                <td class="px-4 py-3"><x-hr-approval-badge :status="$record->approval_status" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Training, Mentor, Coaching compact row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <section id="section-training" class="report-section bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-black text-slate-900 mb-4">Training ({{ $r['training']['total'] }})</h2>
                @if($r['training']['avg_goal_scores'])
                    <p class="text-xs text-slate-500 mb-3">Avg goal score: <strong>{{ $r['training']['avg_goal_scores'] }}</strong></p>
                @endif
                <ul class="space-y-2 text-xs max-h-48 overflow-y-auto">
                    @foreach($r['training']['records']->take(15) as $record)
                        <li class="flex justify-between gap-2 border-b border-slate-50 pb-2">
                            <a href="{{ route('admin.training.show', $record) }}" class="font-bold text-[#111111] truncate">{{ $record->candidate_name }}</a>
                            <span class="text-slate-400 shrink-0">{{ $record->department }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>
            <section id="section-mentor" class="report-section bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-black text-slate-900 mb-4">Mentor ({{ $r['mentor']['total'] }})</h2>
                <ul class="space-y-2 text-xs max-h-48 overflow-y-auto">
                    @foreach($r['mentor']['records']->take(15) as $record)
                        <li class="flex justify-between gap-2 border-b border-slate-50 pb-2">
                            <span class="font-bold truncate">{{ $record->mentee_name }}</span>
                            <span class="text-slate-400 shrink-0">{{ $record->mentor_name }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>
            <section id="section-coaching" class="report-section bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-black text-slate-900 mb-4">Coaching ({{ $r['coaching']['total'] }})</h2>
                <ul class="space-y-2 text-xs max-h-48 overflow-y-auto">
                    @foreach($r['coaching']['records']->take(15) as $record)
                        <li class="flex justify-between gap-2 border-b border-slate-50 pb-2">
                            <a href="{{ route('admin.coaching.show', $record) }}" class="font-bold text-[#111111] truncate">{{ $record->candidate_name }}</a>
                            <span class="text-slate-400 shrink-0">{{ $record->coaching_date ? \Carbon\Carbon::parse($record->coaching_date)->format('M d, Y') : '—' }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>
        </div>

        <!-- Progress Reviews -->
        <section id="section-progress" class="report-section bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100">
                <h2 class="text-lg font-black text-slate-900">Progress Reviews ({{ $r['progress']['total'] }}) — {{ $r['progress']['tracking_entries'] }} tracking entries, {{ $r['progress']['idp_objectives_scored'] }} scored objectives</h2>
            </div>
            <div class="overflow-x-auto max-h-[360px]">
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 text-[10px] font-black uppercase text-slate-400">
                        <tr>
                            <th class="px-4 py-3 text-left">Candidate</th>
                            <th class="px-4 py-3">Dept</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-center">IDP Rows</th>
                            <th class="px-4 py-3 text-center">Dev Link</th>
                            <th class="px-4 py-3">Approval</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($r['progress']['records'] as $record)
                            <tr>
                                <td class="px-4 py-3 font-bold"><a href="{{ route('admin.progress.show', $record) }}" class="text-[#111111]">{{ $record->candidate_name }}</a></td>
                                <td class="px-4 py-3">{{ $record->department }}</td>
                                <td class="px-4 py-3">{{ $record->status }}</td>
                                <td class="px-4 py-3 text-center">{{ $record->idpObjectives->count() }}</td>
                                <td class="px-4 py-3 text-center">{{ $record->development_id ? 'Yes' : 'No' }}</td>
                                <td class="px-4 py-3"><x-hr-approval-badge :status="$record->approval_status" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SD & Leadership -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <section id="section-sd" class="report-section bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-lg font-black text-slate-900 mb-2">Succession Dashboard ({{ $r['succession_dashboard']['total_dashboards'] }} dashboards, {{ $r['succession_dashboard']['total_positions'] }} positions)</h2>
                @foreach($r['succession_dashboard']['dashboards'] as $sd)
                    <div class="mb-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <a href="{{ route('admin.sd.show', $sd) }}" class="font-bold text-[#111111] text-sm">{{ $sd->title }}</a>
                        <p class="text-[10px] text-slate-400">{{ $sd->department }} &bull; {{ $sd->items->count() }} positions</p>
                    </div>
                @endforeach
            </section>
            <section id="section-leadership" class="report-section bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="text-lg font-black text-slate-900">Leadership ({{ $r['leadership']['total'] }}) — Avg {{ $r['leadership']['avg_overall_score'] }}</h2>
                </div>
                @if($r['leadership']['competency_averages']->isNotEmpty())
                    <div class="p-4 border-b border-slate-50">
                        <p class="text-[10px] font-black uppercase text-slate-400 mb-2">Top Competencies (avg rating)</p>
                        @foreach($r['leadership']['competency_averages']->take(5) as $comp)
                            <div class="flex justify-between text-xs py-1">
                                <span>{{ $comp->competency_name }}</span>
                                <span class="font-black">{{ number_format($comp->avg_rating, 1) }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="max-h-48 overflow-y-auto text-xs">
                    @foreach($r['leadership']['records']->take(10) as $record)
                        <div class="px-4 py-2 border-b border-slate-50 flex justify-between">
                            <a href="{{ route('admin.leadership.show', $record) }}" class="font-bold text-[#111111]">{{ $record->candidate_name }}</a>
                            <span class="font-black">{{ number_format($record->overall_score, 1) }}</span>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Transitions -->
        <section id="section-transition" class="report-section bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex flex-wrap gap-4 text-xs font-bold text-slate-500">
                <h2 class="text-lg font-black text-slate-900 w-full">Transition Plans ({{ $r['transitions']['total_plans'] }})</h2>
                <span>Upcoming: {{ $r['transitions']['upcoming'] }}</span>
                <span>Overdue: {{ $r['transitions']['overdue'] }}</span>
            </div>
            <div class="overflow-x-auto max-h-[400px]">
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 text-[10px] font-black uppercase text-slate-400">
                        <tr>
                            <th class="px-4 py-3 text-left">Critical Role</th>
                            <th class="px-4 py-3">Current</th>
                            <th class="px-4 py-3">Successor</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Dept</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($r['transitions']['items'] as $item)
                            <tr>
                                <td class="px-4 py-3 font-bold">{{ $item->critical_role }}</td>
                                <td class="px-4 py-3">{{ $item->current_holder }}</td>
                                <td class="px-4 py-3 text-[#111111] font-bold">{{ $item->successor }}</td>
                                <td class="px-4 py-3">{{ $item->transition_date ? \Carbon\Carbon::parse($item->transition_date)->format('M d, Y') : '—' }}</td>
                                <td class="px-4 py-3">{{ $item->transition?->department ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <footer class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest pt-8 border-t border-slate-100 print-only">
            HR Succession Planning Report &bull; {{ config('app.name') }} &bull; {{ now()->format('Y-m-d H:i') }}
        </footer>
    </div>

    <style>
        .report-section { scroll-margin-top: 6rem; }
        @media print {
            .no-print { display: none !important; }
            .report-page { max-width: 100% !important; padding: 0 !important; }
            .report-section { break-inside: avoid; page-break-inside: avoid; }
            aside, nav, header { display: none !important; }
        }
    </style>
</x-app-layout>
