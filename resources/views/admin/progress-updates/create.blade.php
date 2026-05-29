<x-app-layout>
    <div class="py-10 px-6 space-y-12 max-w-[1400px] mx-auto font-inter">

        <!-- Premium Header -->
        <div class="flex items-center justify-between border-b border-slate-100 pb-10">
            <div class="space-y-1">
                <a href="{{ route('admin.progress-updates.index') }}"
                    class="text-[10px] font-black text-[#D4AF37] uppercase tracking-[0.3em] flex items-center gap-2 mb-4">
                    <i data-lucide="arrow-left" class="w-3 h-3"></i>
                    Back to Registry
                </a>
                <h2 class="text-4xl font-black text-slate-900 tracking-tight font-outfit">Progress <span
                        class="text-[#D4AF37]">Updates</span></h2>
                <p class="text-slate-500 font-medium">Capture real-time project metrics and compute performance indices.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" form="progress-form"
                    class="px-10 py-4 bg-slate-800 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-widest shadow-2xl shadow-slate-900/20 hover:scale-105 active:scale-95 transition-all">
                    Update
                </button>
            </div>
        </div>

        <form action="{{ route('admin.progress-updates.store') }}" method="POST" id="progress-form" class="space-y-12"
            x-data="{ planned: 0, actual: 0 }">
            @csrf

            <!-- Section 1: Project & Performance -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-[#D4AF37]">
                        <i data-lucide="target" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">1. Performance Matrix</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Core performance
                            data and automated indices</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Select
                            Project</label>
                        <select name="project_id" required
                            class="w-full px-6 py-4 bg-white border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-[#D4AF37]/10 focus:bg-white transition-all cursor-pointer" style="background-color:#ffffff;">
                            <option value="">Select Protocol Asset...</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->project_name }} ({{ $project->custom_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Progress
                            Planned (%)</label>
                        <input type="number" step="0.01" name="progress_planned" x-model="planned" required
                            class="w-full px-6 py-4 bg-white border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-[#D4AF37]/10 focus:bg-white transition-all" style="background-color:#ffffff;">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Progress
                            Actual (%)</label>
                        <input type="number" step="0.01" name="progress_actual" x-model="actual" required
                            class="w-full px-6 py-4 bg-white border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-[#D4AF37]/10 focus:bg-white transition-all" style="background-color:#ffffff;">
                    </div>

                    <div
                        class="lg:col-span-3 bg-white p-6 rounded-2xl flex items-center justify-between border border-slate-100">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Calculated SPI
                                Index</p>
                            <h4 class="text-2xl font-black text-slate-900 mt-1"
                                x-text="planned > 0 ? ((actual / planned) * 100).toFixed(2) + '%' : '0.00%'"></h4>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-[#D4AF37] shadow-sm">
                            <i data-lucide="gauge" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Financials & Timeline -->
            <div
                class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-10 relative overflow-hidden">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-emerald-500/5 rounded-full blur-3xl"></div>
                <div class="flex items-center gap-4 relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-emerald-600">
                        <i data-lucide="banknote" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">2. Commercial & Temporal State</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Revenue cycles
                            and completion milestones</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Revenue
                            Planned (ETB)</label>
                        <input type="number" step="0.01" name="revenue_planned"
                            class="w-full px-6 py-4 bg-white border-none rounded-2xl text-xs font-black text-emerald-600 focus:ring-4 focus:ring-emerald-100/50 focus:bg-white transition-all" style="background-color:#ffffff;">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Revenue
                            Actual (ETB)</label>
                        <input type="number" step="0.01" name="revenue_actual"
                            class="w-full px-6 py-4 bg-white border-none rounded-2xl text-xs font-black text-emerald-600 focus:ring-4 focus:ring-emerald-100/50 focus:bg-white transition-all" style="background-color:#ffffff;">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Target
                            Completion Date</label>
                        <input type="date" name="completion_date"
                            class="w-full px-6 py-4 bg-white border-none rounded-2xl text-xs font-black text-slate-700 focus:ring-4 focus:ring-emerald-100/50 focus:bg-white transition-all" style="background-color:#ffffff;">
                    </div>
                </div>
            </div>

            <!-- Section 3: Operational Constraints -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-indigo-600">
                        <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">3. Operational Log</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Constraints,
                            issues and resource monitoring</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Top
                            Constraints</label>
                        <textarea name="top_constraints" rows="3"
                            class="w-full px-6 py-4 bg-white border-none rounded-2xl text-xs font-bold text-slate-700" style="background-color:#ffffff;"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Client
                            Issues</label>
                        <textarea name="client_issue" rows="3"
                            class="w-full px-6 py-4 bg-white border-none rounded-2xl text-xs font-bold text-slate-700" style="background-color:#ffffff;"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Design
                            Completion / Approval</label>
                        <textarea name="design_completion_approval" rows="3"
                            class="w-full px-6 py-4 bg-white border-none rounded-2xl text-xs font-bold text-slate-700" style="background-color:#ffffff;"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Material
                            Submittal / Approval</label>
                        <textarea name="material_submittal_approval" rows="3"
                            class="w-full px-6 py-4 bg-white border-none rounded-2xl text-xs font-bold text-slate-700" style="background-color:#ffffff;"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Material
                            Delivery</label>
                        <textarea name="material_delivery" rows="3"
                            class="w-full px-6 py-4 bg-white border-none rounded-2xl text-xs font-bold text-slate-700" style="background-color:#ffffff;"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Labor</label>
                        <textarea name="labor" rows="3"
                            class="w-full px-6 py-4 bg-white border-none rounded-2xl text-xs font-bold text-slate-700" style="background-color:#ffffff;"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Machinery /
                            Equipment</label>
                        <textarea name="machinery_equipment" rows="3"
                            class="w-full px-6 py-4 bg-white border-none rounded-2xl text-xs font-bold text-slate-700" style="background-color:#ffffff;"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Subcontractor</label>
                        <textarea name="subcontractor" rows="3"
                            class="w-full px-6 py-4 bg-white border-none rounded-2xl text-xs font-bold text-slate-700" style="background-color:#ffffff;"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Finance</label>
                        <textarea name="finance" rows="3"
                            class="w-full px-6 py-4 bg-white border-none rounded-2xl text-xs font-bold text-slate-700" style="background-color:#ffffff;"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Operation
                            Constraint</label>
                        <textarea name="operation_constraint" rows="3"
                            class="w-full px-6 py-4 bg-white border-none rounded-2xl text-xs font-bold text-slate-700" style="background-color:#ffffff;"></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>