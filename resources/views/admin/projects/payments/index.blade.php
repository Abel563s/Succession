<x-app-layout>
    <div class="py-10 px-6 space-y-12 max-w-[1700px] mx-auto font-inter">
        <!-- Modern Compact Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 pb-4 border-b border-slate-100">
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center text-white shadow-xl shadow-slate-900/20">
                        <i data-lucide="banknote" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-light text-slate-400 tracking-tight font-outfit leading-none">
                            Financial <span class="font-black text-slate-900">Protocols</span>
                        </h2>
                        <p class="text-[10px] font-black text-[#D4AF37] uppercase tracking-[0.3em] mt-2">Project Payment
                            Management</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- Assets badge removed -->
            </div>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $project)
                <div class="premium-card group overflow-hidden flex flex-col h-full ring-1 ring-slate-200">
                    <div class="p-6 flex-1">
                        <div class="flex items-start justify-between mb-4">
                            <div
                                class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-slate-900 group-hover:text-white transition-all duration-300">
                                <i data-lucide="building-2" class="w-6 h-6"></i>
                            </div>
                            <span
                                class="px-3 py-1 bg-slate-100 text-slate-400 rounded-lg text-[10px] font-black tracking-widest uppercase">
                                {{ $project->custom_id }}
                            </span>
                        </div>

                        <h3
                            class="text-xl font-black text-slate-900 leading-tight mb-2 group-hover:text-[#D4AF37] transition-colors">
                            {{ $project->project_name }}
                        </h3>

                        <div class="space-y-3 mt-6">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-400 font-black uppercase tracking-widest">Contract Value</span>
                                <span
                                    class="text-slate-900 font-black">${{ number_format($project->total_project_value, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-400 font-black uppercase tracking-widest">Total Certified</span>
                                <span
                                    class="text-amber-500 font-black">${{ number_format($project->total_certified, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-400 font-black uppercase tracking-widest text-[#D4AF37]">Remaining
                                    Balance</span>
                                <span
                                    class="text-slate-900 font-black">${{ number_format($project->total_project_value - $project->total_certified, 2) }}</span>
                            </div>

                            @php
                                $progress = $project->total_project_value > 0 ? ($project->total_certified / $project->total_project_value) * 100 : 0;
                            @endphp

                            <div class="pt-4">
                                <div
                                    class="flex items-center justify-between text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">
                                    <span>Certification Progress</span>
                                    <span>{{ number_format($progress, 1) }}%</span>
                                </div>
                                <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-cyan-400 to-blue-500 rounded-full"
                                        style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50 border-t border-slate-100">
                        <a href="{{ route('admin.projects.payments.manage', $project) }}"
                            class="w-full flex items-center justify-center gap-2 py-3 bg-white border border-slate-200 text-slate-700 font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all duration-300 shadow-sm">
                            <span>Manage Payments</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        @if($projects->isEmpty())
            <div class="premium-card p-24 text-center">
                <div
                    class="w-20 h-20 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mx-auto mb-6 text-slate-300">
                    <i data-lucide="database" class="w-10 h-10"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-900">No Projects Found</h3>
                <p class="text-slate-400 mt-2 font-medium">Create a project first to initialize financial protocols.</p>
                <div class="mt-10">
                    <a href="{{ route('admin.projects.create') }}"
                        class="group/btn relative px-8 py-3.5 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest overflow-hidden transition-all hover:scale-105 active:scale-95 shadow-xl shadow-slate-900/20">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-[#D4AF37] to-blue-500 translate-x-[-100%] group-hover/btn:translate-x-0 transition-transform duration-500">
                        </div>
                        <span class="relative flex items-center gap-2">
                            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                            Add Project
                        </span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>