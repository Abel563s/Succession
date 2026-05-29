<x-app-layout>
    <div class="py-10 px-6 space-y-12 max-w-[1400px] mx-auto font-inter">

        <!-- Premium Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 border-b border-slate-100 pb-10">
            <div class="flex items-center gap-6">
                <x-record-avatar :name="$project->project_name" />
                <div class="space-y-1">
                    <div class="flex items-center gap-3">
                        <h2 class="text-4xl font-black text-slate-900 tracking-tight font-outfit">
                            {{ $project->project_name }}
                        </h2>
                        <span
                            class="px-3 py-1 bg-amber-50 text-[#D4AF37] rounded-xl text-[10px] font-black uppercase tracking-widest">{{ $project->custom_id }}</span>
                    </div>
                    <p class="text-slate-500 font-medium flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                        {{ $project->project_type }} Module | {{ $project->delivery_method }} Protocol
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('admin.projects.edit', $project->id) }}"
                    class="px-8 py-3 bg-slate-800 text-white rounded-[1.25rem] font-black text-xs uppercase tracking-widest shadow-xl shadow-slate-900/10 hover:scale-105 active:scale-95 transition-all">
                    Edit Project
                </a>
                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this project?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="p-4 bg-white border border-slate-100 text-rose-500 rounded-2xl hover:bg-rose-50 transition-all">
                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Main Content: Identity & Stakeholders -->
            <div class="lg:col-span-2 space-y-10">
                <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-8">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <i data-lucide="info" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">Project Detail</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 space-y-1">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Client /
                                Stakeholder</p>
                            <p class="text-sm font-black text-slate-900">
                                {{ $project->project_client ?: 'Not Specified' }}
                            </p>
                            <p class="text-[9px] font-bold text-[#D4AF37] uppercase tracking-tighter">
                                {{ $project->consultancy_sector }} Sector
                            </p>
                        </div>
                        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 space-y-1">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Consulting
                            </p>
                            <p class="text-sm font-black text-slate-900">{{ $project->consultant ?: 'Not Specified' }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Scope of
                            Operations</p>
                        <div
                            class="p-8 bg-slate-50 rounded-[2rem] border border-slate-100 text-sm font-medium text-slate-600 leading-relaxed italic">
                            {{ $project->scope ?: 'No scope definition provided for this protocol.' }}
                        </div>
                    </div>
                </div>

                <!-- Timeline Section -->
                <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">
                            <i data-lucide="clock" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">Execution Timeline</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Baseline
                                Finish</p>
                            <p class="text-lg font-black text-slate-900">
                                {{ $project->baseline_finish_date ? $project->baseline_finish_date->format('M d, Y') : '---' }}
                            </p>
                        </div>
                        <div class="p-6 bg-[#D4AF37] rounded-2xl shadow-lg shadow-cyan-200 text-center">
                            <p class="text-[9px] font-black text-white/70 uppercase tracking-widest mb-2">Approved EOT
                            </p>
                            <p class="text-lg font-black text-white">
                                {{ $project->approved_eot ? $project->approved_eot->format('M d, Y') : 'None Established' }}
                            </p>
                        </div>
                        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Actual Finish
                            </p>
                            <p class="text-lg font-black text-slate-900">
                                {{ $project->actual_finish_date ? $project->actual_finish_date->format('M d, Y') : '---' }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">
                                Baseline Start</p>
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 font-black text-xs">
                                {{ $project->baseline_start_date ? $project->baseline_start_date->format('M d, Y') : '---' }}
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Actual
                                Start</p>
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 font-black text-xs">
                                {{ $project->actual_start_date ? $project->actual_start_date->format('M d, Y') : '---' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar: Financials & Status -->
            <div class="space-y-10">
                <!-- Status Card -->
                <div
                    class="bg-slate-800 p-8 rounded-[3rem] shadow-2xl shadow-slate-900/40 text-white space-y-6 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-[#D4AF37]/20 rounded-full blur-3xl"></div>
                    <div class="relative z-10 flex items-center justify-between">
                        <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">Operational
                            State</span>
                        <span class="w-2 h-2 rounded-full bg-[#D4AF37] animate-pulse"></span>
                    </div>
                    <div class="relative z-10">
                        <h4 class="text-2xl font-black tracking-tight">{{ $project->closing_status }}</h4>
                        <p class="text-[10px] font-black text-white/40 uppercase tracking-widest mt-1">Revision Node:
                            {{ $project->revision_number ?: '0.0' }}
                        </p>
                    </div>

                    <div class="relative z-10 space-y-3">
                        <div class="flex items-center justify-between text-[10px] font-black text-white/60">
                            <span>PPA PROTOCOL</span>
                            <span>{{ $project->ppa_received_at ? $project->ppa_received_at->format('M d, Y') : 'UNSET' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-[10px] font-black text-white/60">
                            <span>PA PROTOCOL</span>
                            <span>{{ $project->pa_received_at ? $project->pa_received_at->format('M d, Y') : 'UNSET' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-[10px] font-black text-white/60">
                            <span>FA PROTOCOL</span>
                            <span>{{ $project->fa_received_at ? $project->fa_received_at->format('M d, Y') : 'UNSET' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Financial Card -->
                <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-slate-50 space-y-8">
                    <div class="space-y-4">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Financial
                            Allocation (ETB)</p>

                        <div class="space-y-6">
                            <div class="flex items-center justify-between pb-4 border-b border-slate-50">
                                <div>
                                    <p class="text-xs font-black text-slate-900">ETB
                                        {{ number_format($project->contract_budget) }}
                                    </p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Baseline
                                        Budget</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[9px] font-black text-[#D4AF37] uppercase tracking-widest">
                                        +{{ number_format($project->variation + $project->supplementary) }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Delta
                                        Adjustment</p>
                                </div>
                            </div>

                            <div class="p-6 bg-slate-50 rounded-2xl text-center space-y-1">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Total
                                    Portfolio Value</p>
                                <p class="text-2xl font-black text-slate-900 tracking-tighter">ETB
                                    {{ number_format($project->total_project_value) }}
                                </p>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Allowable
                                        Cost</p>
                                    <p class="text-xs font-black text-slate-700">ETB
                                        {{ number_format($project->total_allowable_cost) }}
                                    </p>
                                </div>
                                <div class="flex items-center justify-between">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Cost at
                                        Completion</p>
                                    <p class="text-xs font-black text-slate-700">ETB
                                        {{ number_format($project->cost_at_completion) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>