<x-app-layout>
    <div class="py-6 px-6 space-y-8 max-w-[1700px] mx-auto font-inter">
        
        <!-- Premium Welcome/Header Section -->
        <div class="grid grid-cols-1 xl:grid-cols-3 items-center gap-6 pb-6 border-b border-slate-200">
            <!-- Left: Welcome Message -->
            <div class="xl:col-span-2 space-y-1">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#00ADC5] to-[#083344] flex items-center justify-center text-white shadow-lg shadow-[#083344]/20">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                            Control <span class="text-[#083344]">Center</span>
                        </h2>
                        <p class="text-[10px] font-black text-[#00ADC5] uppercase tracking-[0.2em] mt-0.5">HR Executive Succession & Development Hub</p>
                    </div>
                </div>
                <div class="text-xs font-medium text-slate-500 mt-2">
                    Welcome back, <span class="font-bold text-slate-800">{{ auth()->user()->name }}</span> &bull; 
                    <span class="text-slate-400 font-normal">{{ date('l, F d, Y') }}</span>
                </div>
            </div>

            <!-- Right: Quick Actions -->
            <div class="flex flex-wrap gap-3 xl:justify-end">
                <a href="{{ route('admin.progress.create') }}" 
                   class="bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 px-4 py-2.5 rounded-xl font-bold text-xs flex items-center gap-1.5 transition-all hover:scale-[1.02] shadow-sm">
                    <i data-lucide="bar-chart-2" class="w-4 h-4 text-[#00ADC5]"></i>
                    New Progress
                </a>
                <a href="{{ route('admin.leadership.create') }}" 
                   class="bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 px-4 py-2.5 rounded-xl font-bold text-xs flex items-center gap-1.5 transition-all hover:scale-[1.02] shadow-sm">
                    <i data-lucide="award" class="w-4 h-4 text-[#00ADC5]"></i>
                    Add Leadership
                </a>
                <a href="{{ route('admin.successions.create') }}" 
                   class="bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 px-4 py-2.5 rounded-xl font-bold text-xs flex items-center gap-1.5 transition-all hover:scale-[1.02] shadow-sm">
                    <i data-lucide="trending-up" class="w-4 h-4 text-[#00ADC5]"></i>
                    Add Succession
                </a>
                <a href="{{ route('admin.transition.create') }}" 
                   class="bg-gradient-to-r from-[#00ADC5] to-[#083344] text-white px-4 py-2.5 rounded-xl font-bold text-xs flex items-center gap-1.5 transition-all hover:scale-[1.02] shadow-md shadow-[#083344]/15">
                    <i data-lucide="refresh-ccw" class="w-4 h-4"></i>
                    Add Transition
                </a>
            </div>
        </div>

        <!-- Summary Stat Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
            <!-- 1. Critical Roles Card -->
            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Critical Roles</span>
                    <span class="p-2 rounded-xl bg-rose-50 text-rose-500"><i data-lucide="shield-alert" class="w-4 h-4"></i></span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-900">{{ $criticalRolesCount }}</span>
                    <span class="text-xs font-bold text-rose-500 uppercase">Active</span>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-100 text-[10px] font-bold text-slate-400">
                    <div>Vacant: <span class="text-slate-800 font-black">{{ $vacantCriticalRoles }}</span></div>
                    <div>No Successors: <span class="text-slate-800 font-black">{{ $rolesWithoutSuccessors }}</span></div>
                </div>
            </div>

            <!-- 2. Succession Card -->
            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Succession Plans</span>
                    <span class="p-2 rounded-xl bg-cyan-50 text-[#00ADC5]"><i data-lucide="trending-up" class="w-4 h-4"></i></span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-900">{{ $successionPlansCount }}</span>
                    <span class="text-xs font-bold text-[#00ADC5] uppercase">Plans</span>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-100 text-[10px] font-bold text-slate-400">
                    <div>Ready Now: <span class="text-slate-800 font-black">{{ $highReadinessCandidates }}</span></div>
                    <div>Unstaffed: <span class="text-slate-800 font-black">{{ $rolesRequiringSuccessors }}</span></div>
                </div>
            </div>

            <!-- 3. Leadership Card -->
            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Leadership Assessment</span>
                    <span class="p-2 rounded-xl bg-amber-50 text-amber-500"><i data-lucide="award" class="w-4 h-4"></i></span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-900">{{ $leadershipCount }}</span>
                    <span class="text-xs font-bold text-amber-500 uppercase">Assessed</span>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-100 text-[10px] font-bold text-slate-400">
                    <div>Completed: <span class="text-slate-800 font-black">{{ $leadershipCompleted }}</span></div>
                    <div>Avg Score: <span class="text-slate-800 font-black">{{ $avgLeadershipScore }}/5</span></div>
                </div>
            </div>

            <!-- 4. Transition Plans Card -->
            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Transition Plans</span>
                    <span class="p-2 rounded-xl bg-blue-50 text-blue-500"><i data-lucide="refresh-ccw" class="w-4 h-4"></i></span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-900">{{ $upcomingTransitions }}</span>
                    <span class="text-xs font-bold text-blue-500 uppercase">Pending</span>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-100 text-[10px] font-bold text-slate-400">
                    <div>Done: <span class="text-slate-800 font-black">{{ $completedTransitions }}</span></div>
                    <div>Delayed: <span class="text-slate-800 font-black text-rose-500">{{ $delayedTransitions }}</span></div>
                </div>
            </div>

            <!-- 5. Progress Reviews Card -->
            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Progress Reviews</span>
                    <span class="p-2 rounded-xl bg-emerald-50 text-emerald-500"><i data-lucide="bar-chart-2" class="w-4 h-4"></i></span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-900">{{ $progressCount }}</span>
                    <span class="text-xs font-bold text-emerald-500 uppercase">Total</span>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-100 text-[10px] font-bold text-slate-400">
                    <div>Pending: <span class="text-slate-800 font-black text-amber-500">{{ $progressPending }}</span></div>
                    <div>Completed: <span class="text-slate-800 font-black text-emerald-600">{{ $progressCompleted }}</span></div>
                </div>
            </div>
        </div>

        <!-- Quick Access Module Cards -->
        <div class="space-y-4">
            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                <span class="w-1.5 h-4 bg-[#083344] rounded-full"></span>
                Quick Access Modules
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                <!-- Critical Role -->
                <a href="{{ route('admin.critical-roles.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all group flex flex-col justify-between h-40">
                    <div class="flex items-center justify-between">
                        <span class="w-10 h-10 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-all"><i data-lucide="shield-check" class="w-5 h-5"></i></span>
                        <i data-lucide="arrow-up-right" class="w-4 h-4 text-slate-300 group-hover:text-[#00ADC5] transition-all"></i>
                    </div>
                    <div>
                        <p class="font-black text-slate-800 text-sm">Critical Roles</p>
                        <p class="text-[10px] text-slate-400 font-medium mt-1">Strategic Org Security</p>
                    </div>
                </a>

                <!-- Succession -->
                <a href="{{ route('admin.successions.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all group flex flex-col justify-between h-40">
                    <div class="flex items-center justify-between">
                        <span class="w-10 h-10 rounded-xl bg-cyan-50 text-[#00ADC5] flex items-center justify-center group-hover:bg-[#00ADC5] group-hover:text-white transition-all"><i data-lucide="trending-up" class="w-5 h-5"></i></span>
                        <i data-lucide="arrow-up-right" class="w-4 h-4 text-slate-300 group-hover:text-[#00ADC5] transition-all"></i>
                    </div>
                    <div>
                        <p class="font-black text-slate-800 text-sm">Succession Plans</p>
                        <p class="text-[10px] text-slate-400 font-medium mt-1">Successor Pipelines</p>
                    </div>
                </a>

                <!-- 9-Box Grid -->
                <a href="{{ route('admin.nine-box.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all group flex flex-col justify-between h-40">
                    <div class="flex items-center justify-between">
                        <span class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center group-hover:bg-indigo-500 group-hover:text-white transition-all"><i data-lucide="grid-3x3" class="w-5 h-5"></i></span>
                        <i data-lucide="arrow-up-right" class="w-4 h-4 text-slate-300 group-hover:text-[#D4AF37] transition-all"></i>
                    </div>
                    <div>
                        <p class="font-black text-slate-800 text-sm">9-Box Grid</p>
                        <p class="text-[10px] text-slate-400 font-medium mt-1">Talent Bench Mapping</p>
                    </div>
                </a>

                <!-- Development -->
                <a href="{{ route('admin.development.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all group flex flex-col justify-between h-40">
                    <div class="flex items-center justify-between">
                        <span class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center group-hover:bg-teal-600 group-hover:text-white transition-all"><i data-lucide="user-plus" class="w-5 h-5"></i></span>
                        <i data-lucide="arrow-up-right" class="w-4 h-4 text-slate-300 group-hover:text-[#D4AF37] transition-all"></i>
                    </div>
                    <div>
                        <p class="font-black text-slate-800 text-sm">IDP Development</p>
                        <p class="text-[10px] text-slate-400 font-medium mt-1">Growth Roadmaps</p>
                    </div>
                </a>

                <!-- Mentor & Coaching -->
                <a href="{{ route('admin.mentor.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all group flex flex-col justify-between h-40">
                    <div class="flex items-center justify-between">
                        <span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all"><i data-lucide="users" class="w-5 h-5"></i></span>
                        <i data-lucide="arrow-up-right" class="w-4 h-4 text-slate-300 group-hover:text-[#D4AF37] transition-all"></i>
                    </div>
                    <div>
                        <p class="font-black text-slate-800 text-sm">Mentorship</p>
                        <p class="text-[10px] text-slate-400 font-medium mt-1">Guidance Handovers</p>
                    </div>
                </a>

                <!-- Leadership -->
                <a href="{{ route('admin.leadership.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all group flex flex-col justify-between h-40">
                    <div class="flex items-center justify-between">
                        <span class="w-10 h-10 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-all"><i data-lucide="award" class="w-5 h-5"></i></span>
                        <i data-lucide="arrow-up-right" class="w-4 h-4 text-slate-300 group-hover:text-[#D4AF37] transition-all"></i>
                    </div>
                    <div>
                        <p class="font-black text-slate-800 text-sm">Leadership</p>
                        <p class="text-[10px] text-slate-400 font-medium mt-1">Capability Analysis</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Dashboard Charts & Analytics Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- 1. Succession Readiness Overview -->
            <div class="bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-[#083344] rounded-full"></span>
                        Succession Readiness Overview
                    </h3>
                    <span class="text-[10px] font-black text-[#00ADC5] uppercase tracking-wider">Interactive Distribution</span>
                </div>
                <div class="relative h-64 flex items-center justify-center">
                    <canvas id="readinessChart" class="max-h-full"></canvas>
                </div>
            </div>

            <!-- 2. Leadership Distribution Chart -->
            <div class="bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-[#083344] rounded-full"></span>
                        Leadership Ratings & Skill Breakdown
                    </h3>
                    <span class="text-[10px] font-black text-[#00ADC5] uppercase tracking-wider">Standard Competencies</span>
                </div>
                <div class="relative h-64 flex items-center justify-center">
                    <canvas id="leadershipChart" class="max-h-full"></canvas>
                </div>
            </div>
        </div>

        <!-- Tables & Activity Feed -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            
            <!-- Left 2 Cols: Recent Data tables -->
            <div class="xl:col-span-2 space-y-6">
                <!-- Recent Transitions Plan Table -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-1.5 h-4 bg-[#083344] rounded-full"></span>
                            Recent Transition Schedules
                        </h4>
                        <a href="{{ route('admin.transition.index') }}" class="text-[10px] font-black text-[#00ADC5] uppercase hover:underline">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-[10px] font-black uppercase text-slate-400">
                                    <th class="px-5 py-3">Critical Role</th>
                                    <th class="px-5 py-3">Successor</th>
                                    <th class="px-5 py-3">Transition Date</th>
                                    <th class="px-5 py-3 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($recentTransitions as $rt)
                                    @foreach($rt->items->take(1) as $item)
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-5 py-3 font-bold text-slate-800">{{ $item->critical_role }}</td>
                                            <td class="px-5 py-3 font-bold text-[#00ADC5]">{{ $item->successor }}</td>
                                            <td class="px-5 py-3 font-medium text-slate-500">{{ date('M d, Y', strtotime($item->transition_date)) }}</td>
                                            <td class="px-5 py-3 text-center">
                                                <span class="inline-flex px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider border border-slate-200 bg-slate-50 text-slate-500">
                                                    {{ $rt->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-6 text-center text-slate-400 italic">No transition schedules documented.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Leadership Assessments -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-1.5 h-4 bg-[#083344] rounded-full"></span>
                            Latest Leadership Evaluations
                        </h4>
                        <a href="{{ route('admin.leadership.index') }}" class="text-[10px] font-black text-[#00ADC5] uppercase hover:underline">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-[10px] font-black uppercase text-slate-400">
                                    <th class="px-5 py-3">Candidate</th>
                                    <th class="px-5 py-3">Department</th>
                                    <th class="px-5 py-3">Score</th>
                                    <th class="px-5 py-3 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($recentLeadership as $rl)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-5 py-3 font-bold text-slate-800">{{ $rl->candidate_name }}</td>
                                        <td class="px-5 py-3 text-slate-500 font-medium">{{ $rl->department }}</td>
                                        <td class="px-5 py-3 font-black text-slate-900">{{ $rl->overall_score }}/5</td>
                                        <td class="px-5 py-3 text-center">
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-[9px] font-black uppercase border border-emerald-100 bg-emerald-50 text-emerald-600">
                                                {{ $rl->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-6 text-center text-slate-400 italic">No leadership evaluations recorded.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Reminders / Notification Panel -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-1.5 h-4 bg-[#083344] rounded-full"></span>
                            Upcoming Reminders
                        </h4>
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                    </div>

                    <div class="space-y-4">
                        @if($rolesWithoutSuccessors > 0)
                            <div class="flex gap-3 p-3.5 bg-rose-50/50 border border-rose-100 rounded-2xl">
                                <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-500 flex items-center justify-center shrink-0">
                                    <i data-lucide="shield-alert" class="w-4 h-4"></i>
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-xs font-black text-slate-800">Critical Roles Unsecured</p>
                                    <p class="text-[10px] text-slate-500 font-medium font-inter leading-relaxed">
                                        There are <span class="font-black text-rose-600">{{ $rolesWithoutSuccessors }}</span> critical roles without identified successors.
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if($vacantCriticalRoles > 0)
                            <div class="flex gap-3 p-3.5 bg-amber-50/50 border border-amber-100 rounded-2xl">
                                <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                    <i data-lucide="user-minus" class="w-4 h-4"></i>
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-xs font-black text-slate-800">Positions Currently Vacant</p>
                                    <p class="text-[10px] text-slate-500 font-medium font-inter leading-relaxed">
                                        There are <span class="font-black text-amber-600">{{ $vacantCriticalRoles }}</span> key vacancies requiring immediate succession attention.
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if($upcomingTransitions > 0)
                            <div class="flex gap-3 p-3.5 bg-blue-50/50 border border-blue-100 rounded-2xl">
                                <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-500 flex items-center justify-center shrink-0">
                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-xs font-black text-slate-800">Active Handovers Scheduled</p>
                                    <p class="text-[10px] text-slate-500 font-medium font-inter leading-relaxed">
                                        You have <span class="font-black text-blue-600">{{ $upcomingTransitions }}</span> handovers and transitions active on the schedule.
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if($progressPending > 0)
                            <div class="flex gap-3 p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl">
                                <div class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-500 flex items-center justify-center shrink-0">
                                    <i data-lucide="clock" class="w-4 h-4"></i>
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-xs font-black text-slate-800">Progress Appraisals Pending</p>
                                    <p class="text-[10px] text-slate-500 font-medium font-inter leading-relaxed">
                                        There are <span class="font-black text-indigo-600">{{ $progressPending }}</span> pending progress updates requiring admin authorization.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ChartJS and Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // 1. Readiness Chart
            const ctxReadiness = document.getElementById('readinessChart').getContext('2d');
            new Chart(ctxReadiness, {
                type: 'doughnut',
                data: {
                    labels: ['High Readiness', 'Standard Bench', 'Developing'],
                    datasets: [{
                        data: [
                            {{ $highReadinessCandidates }},
                            {{ max(0, $successionPlansCount - $highReadinessCandidates) }},
                            {{ $rolesWithoutSuccessors }}
                        ],
                        backgroundColor: ['#00ADC5', '#083344', '#BEEAF0'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    size: 10,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    cutout: '75%'
                }
            });

            // 2. Leadership rating
            const ctxLeadership = document.getElementById('leadershipChart').getContext('2d');
            new Chart(ctxLeadership, {
                type: 'bar',
                data: {
                    labels: ['Completed Assessments', 'Target Goal score', 'Current Avg Rating'],
                    datasets: [{
                        label: 'Leadership Progress',
                        data: [{{ $leadershipCompleted }}, 5, {{ $avgLeadershipScore }}],
                        backgroundColor: ['#083344', '#00ADC5', '#F59E0B'],
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 10
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>