<x-app-layout>
    <div class="py-10 px-6 space-y-12 max-w-[1400px] mx-auto font-inter">

        <!-- Modern Compact Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 pb-4 border-b border-slate-100">
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.projects.closeout.index') }}" 
                       class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-[#D4AF37] hover:border-[#D4AF37]/20 hover:rotate-[-10deg] transition-all shadow-sm">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>
                    <div>
                        <h2 class="text-3xl font-light text-slate-400 tracking-tight font-outfit leading-none">
                            Project <span class="font-black text-slate-900">Closeout</span>
                        </h2>
                        <p class="text-[10px] font-black text-[#D4AF37] uppercase tracking-[0.3em] mt-2">{{ $project->project_name }} - {{ $project->custom_id }}</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button onclick="window.print()" 
                        class="group/btn relative px-6 py-3.5 bg-white border border-slate-100 text-slate-600 rounded-2xl font-black text-[10px] uppercase tracking-widest overflow-hidden transition-all hover:bg-slate-50 active:scale-95 shadow-sm">
                    <span class="relative flex items-center gap-2">
                        <i data-lucide="printer" class="w-3.5 h-3.5 text-[#D4AF37]"></i>
                        Print Dossier
                    </span>
                </button>
                
                <a href="{{ route('admin.projects.edit', $project->id) }}"
                   class="group/btn relative px-8 py-3.5 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest overflow-hidden transition-all hover:scale-105 active:scale-95 shadow-xl shadow-slate-900/20">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#D4AF37] to-blue-500 translate-x-[-100%] group-hover/btn:translate-x-0 transition-transform duration-500"></div>
                    <span class="relative flex items-center gap-2">
                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                        Update Details
                    </span>
                </a>
            </div>
        </div>

        <!-- SECTION 1: Executive Summary (Modern Cards) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1: Project Identity -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <i data-lucide="briefcase" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Asset Identity</p>
                    <h4 class="text-lg font-black text-slate-900 leading-tight">{{ $project->project_name }}</h4>
                    <p class="text-[10px] font-bold text-indigo-500 uppercase mt-1">{{ $project->project_client }}</p>
                </div>
            </div>

            <!-- Card 2: Financial Magnitude -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <i data-lucide="banknote" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Final Contract Sum</p>
                    <h4 class="text-lg font-black text-slate-900 leading-tight">ETB {{ number_format($project->total_project_value) }}</h4>
                    <p class="text-[10px] font-bold text-emerald-500 uppercase mt-1">Total Reconciliation</p>
                </div>
            </div>

            <!-- Card 3: Payment Status -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-[#D4AF37]/20 shadow-xl shadow-cyan-50 text-slate-900 space-y-4 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-[#D4AF37]/5 rounded-full blur-2xl group-hover:bg-[#D4AF37]/10 transition-all"></div>
                <div class="w-12 h-12 rounded-2xl bg-[#e6f7fa] flex items-center justify-center text-[#D4AF37]">
                    <i data-lucide="wallet" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Outstanding Balance</p>
                    <h4 class="text-xl font-black text-slate-900 leading-tight">ETB {{ number_format($project->outstanding_balance) }}</h4>
                    <p class="text-[10px] font-bold text-[#D4AF37] uppercase mt-1">Total Balance</p>
                </div>
                <!-- Mini sparkline effect -->
                <div class="h-8 flex items-end gap-1">
                    @foreach([40, 70, 45, 90, 65, 80, 50, 85] as $h)
                        <div class="flex-1 bg-cyan-100 rounded-sm" style="height: {{ $h }}%"></div>
                    @endforeach
                </div>
            </div>

            <!-- Card 4: Execution Progress -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-[#D4AF37]">
                    <i data-lucide="trending-up" class="w-6 h-6"></i>
                </div>
                <div class="space-y-3">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Physical Completion</p>
                    <div class="flex items-end justify-between">
                        <h4 class="text-lg font-black text-slate-900 leading-none">{{ number_format($project->physical_completion_percent) }}%</h4>
                        <span class="text-[9px] font-black text-slate-400">STATE: {{ $project->physical_completion_percent >= 100 ? 'FINALIZED' : 'ACTIVE' }}</span>
                    </div>
                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-[#D4AF37] rounded-full" style="width: {{ $project->physical_completion_percent }}%"></div>
                    </div>
                </div>
                <!-- Mini Circle Graph -->
                <div class="flex justify-center pt-2">
                    <div class="relative w-16 h-16">
                        <svg class="w-full h-full" viewBox="0 0 36 36">
                            <path class="text-slate-100" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="text-[#D4AF37]" stroke-width="3" stroke-dasharray="{{ $project->physical_completion_percent }}, 100" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center text-[10px] font-black text-slate-900">{{ number_format($project->physical_completion_percent) }}%</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            
            <!-- SECTION 2: Project Information -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-900">
                            <i data-lucide="info" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight">Project Metadata</h3>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Operational registry details</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                    <div class="space-y-1">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Project Name</p>
                        <p class="text-sm font-black text-slate-900 tracking-tight">{{ $project->project_name }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Client Node</p>
                        <p class="text-sm font-black text-slate-900 tracking-tight">{{ $project->project_client }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Asset Location</p>
                        <p class="text-sm font-black text-slate-900 tracking-tight">{{ $project->location ?: 'Not Listed' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Lead Manager</p>
                        <p class="text-sm font-black text-slate-900 tracking-tight">{{ $project->project_manager ?: 'Pending Assignment' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Reconnaissance Start</p>
                        <p class="text-sm font-black text-slate-900 tracking-tight">{{ $project->actual_start_date ? $project->actual_start_date->format('M d, Y') : '---' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Final Handover</p>
                        <p class="text-sm font-black text-slate-900 tracking-tight">{{ $project->actual_finish_date ? $project->actual_finish_date->format('M d, Y') : '---' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Protocol Duration</p>
                        <p class="text-sm font-black text-slate-900 tracking-tight">{{ $project->actual_duration }} Days</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Current Status</p>
                        <span class="inline-flex px-3 py-1 bg-amber-50 text-[#D4AF37] rounded-lg text-[9px] font-black uppercase tracking-widest mt-1">{{ $project->closing_status }}</span>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: Financial Summary -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <i data-lucide="bar-chart-3" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">Financial Audit</h3>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Reconciliation of capital deployment</p>
                    </div>
                </div>

                <div class="space-y-8">
                    <!-- A. Contract Details -->
                    <div class="space-y-4">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-50 pb-2">A. Contract Details</p>
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-medium text-slate-500">Original Contract Sum</span>
                            <span class="font-black text-slate-900">ETB {{ number_format($project->contract_budget) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-medium text-slate-500">Variations & Supplementary</span>
                            <span class="font-black text-emerald-500">+ ETB {{ number_format($project->variation + $project->supplementary) }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                            <span class="text-xs font-black text-slate-600 uppercase tracking-widest">Revised Contract Sum</span>
                            <span class="text-lg font-black text-slate-900">ETB {{ number_format($project->total_project_value) }}</span>
                        </div>
                    </div>

                    <!-- B. Payment Summary -->
                    <div class="space-y-4">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-50 pb-2">B. Payment Summary</p>
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-medium text-slate-500">Total Certified</span>
                            <span class="font-black text-slate-900">ETB {{ number_format($project->total_certified) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-rose-500">
                            <span class="font-medium">Retention (Held)</span>
                            <span class="font-black">- ETB {{ number_format($project->retention) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-[#D4AF37]">
                            <span class="font-bold">Total Paid to Date</span>
                            <span class="font-black">ETB {{ number_format($project->total_paid) }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-slate-900 rounded-2xl text-white shadow-xl shadow-slate-200">
                            <span class="text-xs font-black uppercase tracking-widest text-white/50">Outstanding Balance</span>
                            <span class="text-lg font-black text-white">ETB {{ number_format($project->outstanding_balance) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 4: Technical Completion -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">
                        <i data-lucide="check-square" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">Technical Protocol</h3>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Engineering and handover states</p>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100 space-y-4">
                        <div class="flex items-center justify-between text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <span>Physical Progress Baseline</span>
                            <span class="text-[#D4AF37]">{{ number_format($project->physical_completion_percent) }}% COMPREHENSIVE</span>
                        </div>
                        <div class="h-3 w-full bg-white rounded-full overflow-hidden border border-slate-100 p-0.5">
                            <div class="h-full bg-gradient-to-r from-cyan-400 to-indigo-500 rounded-full" style="width: {{ $project->physical_completion_percent }}%"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="p-5 border border-slate-50 rounded-2xl space-y-1">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Handover Date</p>
                            <p class="text-sm font-black text-slate-900">{{ $project->handover_date ? $project->handover_date->format('M d, Y') : 'PENDING' }}</p>
                        </div>
                        <div class="p-5 border border-slate-50 rounded-2xl space-y-1">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Liability Period</p>
                            <p class="text-sm font-black text-slate-900">{{ $project->defects_liability_period ?: 'Not Defined' }}</p>
                        </div>
                        <div class="p-5 border border-slate-50 rounded-2xl space-y-2">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Snag List</p>
                            @php
                                $snagColors = [
                                    'Pending' => 'bg-amber-100 text-amber-600',
                                    'In Progress' => 'bg-indigo-100 text-indigo-600',
                                    'Completed' => 'bg-emerald-100 text-emerald-600',
                                ];
                            @endphp
                            <span class="inline-flex px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $snagColors[$project->snag_list_status] ?? 'bg-slate-100' }}">
                                {{ $project->snag_list_status }}
                            </span>
                        </div>
                        <div class="p-5 border border-slate-50 rounded-2xl space-y-2">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Completion Cert</p>
                            @php
                                $certColors = [
                                    'Pending' => 'bg-rose-100 text-rose-600',
                                    'Issued' => 'bg-emerald-100 text-emerald-600',
                                ];
                            @endphp
                            <span class="inline-flex px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $certColors[$project->completion_certificate_status] ?? 'bg-slate-100' }}">
                                {{ $project->completion_certificate_status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 5: Document Checklist -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-[#D4AF37]">
                        <i data-lucide="folder-check" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">Dossier Checklist</h3>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Verification of final protocol documentation</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[9px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">
                                <th class="pb-4">Document Logic</th>
                                <th class="pb-4">Status</th>
                                <th class="pb-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach([
                                'Completion Certificate' => 'doc_completion_cert_status',
                                'As-Built Drawings' => 'doc_as_built_status',
                                'Final BOQ' => 'doc_final_boq_status',
                                'Handover Report' => 'doc_handover_report_status'
                            ] as $label => $field)
                            <tr class="group">
                                <td class="py-5 font-bold text-sm text-slate-700">{{ $label }}</td>
                                <td class="py-5">
                                    @php
                                        $docStatus = $project->$field;
                                        $docColors = [
                                            'Uploaded' => 'bg-emerald-50 text-emerald-600',
                                            'Pending' => 'bg-amber-50 text-amber-600',
                                            'Approved' => 'bg-indigo-50 text-indigo-600',
                                        ];
                                    @endphp
                                    <span class="inline-flex px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $docColors[$docStatus] ?? 'bg-slate-50 text-slate-400' }}">
                                        {{ $docStatus }}
                                    </span>
                                </td>
                                <td class="py-5 text-right">
                                    @if($docStatus == 'Uploaded' || $docStatus == 'Approved')
                                        <button class="text-[10px] font-black text-[#D4AF37] uppercase tracking-widest hover:underline">View Asset</button>
                                    @else
                                        <button class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-[#D4AF37]">Upload</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECTION 6: Lessons Learned / Closeout Notes -->
            <div class="lg:col-span-2 bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center text-white">
                        <i data-lucide="lightbulb" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">Intelligence & Lessons Learned</h3>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Post-operational analysis and intelligence</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 text-[10px] font-black text-rose-500 uppercase tracking-widest">
                            <i data-lucide="alert-triangle" class="w-3 h-3"></i>
                            Challenges Faced
                        </div>
                        <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100 text-xs font-medium text-slate-600 leading-relaxed italic">
                            {{ $project->challenges_faced ?: 'No significant operational challenges were recorded for this reconnaissance protocol.' }}
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-2 text-[10px] font-black text-indigo-500 uppercase tracking-widest">
                            <i data-lucide="dollar-sign" class="w-3 h-3"></i>
                            Financial Performance
                        </div>
                        <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100 text-xs font-medium text-slate-600 leading-relaxed italic">
                            {{ $project->financial_performance_notes ?: 'Financial deployment remained within established baseline variances.' }}
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-2 text-[10px] font-black text-amber-500 uppercase tracking-widest">
                            <i data-lucide="clock" class="w-3 h-3"></i>
                            Schedule Performance
                        </div>
                        <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100 text-xs font-medium text-slate-600 leading-relaxed italic">
                            {{ $project->schedule_performance_notes ?: 'Project timeline was reconciled with no critical path deviations.' }}
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-2 text-[10px] font-black text-[#D4AF37] uppercase tracking-widest">
                            <i data-lucide="sparkles" class="w-3 h-3"></i>
                            Recommendations
                        </div>
                        <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100 text-xs font-medium text-slate-600 leading-relaxed italic">
                            {{ $project->recommendations ?: 'Operational logic should be archived for future protocol replication.' }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('styles')
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .bg-slate-50, .bg-indigo-50, .bg-emerald-50, .bg-amber-50, .bg-amber-50 { background-color: #f8fafc !important; }
            .shadow-sm, .shadow-xl, .shadow-2xl { shadow: none !important; box-shadow: none !important; }
            .rounded-[3rem], .rounded-[2.5rem] { border-radius: 1rem !important; }
        }
    </style>
    @endpush
</x-app-layout>
