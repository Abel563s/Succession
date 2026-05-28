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
                <h2 class="text-4xl font-black text-slate-900 tracking-tight font-outfit">Refine <span
                        class="text-[#D4AF37]">Project Detail</span></h2>
                <p class="text-slate-500 font-medium">Update real-time project metrics and performance parameters.</p>
            </div>

            <div class="flex items-center gap-3">
                 <form action="{{ route('admin.progress-updates.destroy', $update->id) }}" method="POST" onsubmit="return confirm('Archive this protocol iteration?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-4 bg-rose-50 text-rose-600 rounded-2xl hover:bg-rose-100 transition-all">
                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                    </button>
                </form>
                <button type="submit" form="progress-form"
                    class="px-10 py-4 bg-slate-800 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-widest shadow-2xl shadow-slate-900/20 hover:scale-105 active:scale-95 transition-all">
                    Create
                </button>
            </div>
        </div>

        <form action="{{ route('admin.progress-updates.update', $update->id) }}" method="POST" id="progress-form" class="space-y-12" x-data="{ planned: {{ $update->progress_planned }}, actual: {{ $update->progress_actual }} }">
            @csrf
            @method('PUT')

            <!-- Section 1: Project & Performance -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-10 group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-[#D4AF37]">
                        <i data-lucide="target" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">1. Performance Matrix</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Core performance data and automated indices</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Protocol Asset</label>
                        <select name="project_id" required
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all cursor-pointer">
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ $update->project_id == $project->id ? 'selected' : '' }}>
                                    {{ $project->project_name }} ({{ $project->custom_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Progress Planned (%)</label>
                        <input type="number" step="0.01" name="progress_planned" x-model="planned" required
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Progress Actual (%)</label>
                        <input type="number" step="0.01" name="progress_actual" x-model="actual" required
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all">
                    </div>

                    <div class="lg:col-span-3 bg-slate-50 p-6 rounded-2xl flex items-center justify-between border border-slate-100">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Calculated SPI Index</p>
                            <h4 class="text-2xl font-black text-slate-900 mt-1" x-text="planned > 0 ? ((actual / planned) * 100).toFixed(2) + '%' : '0.00%'"></h4>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-[#D4AF37] shadow-sm">
                            <i data-lucide="gauge" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Financials & Timeline -->
            <div class="bg-slate-800 p-10 rounded-[3rem] shadow-2xl shadow-slate-900/40 space-y-10 relative overflow-hidden">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
                <div class="flex items-center gap-4 relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-emerald-400">
                        <i data-lucide="banknote" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-white tracking-tight">2. Commercial & Temporal State</h3>
                        <p class="text-[10px] font-black text-white/40 uppercase tracking-widest mt-1">Revenue cycles and completion milestones</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-white/40 uppercase tracking-widest ml-1">Revenue Planned (ETB)</label>
                        <input type="number" step="0.01" name="revenue_planned" value="{{ $update->revenue_planned }}"
                            class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-xs font-black text-emerald-400 focus:ring-4 focus:ring-emerald-500/20 focus:bg-white/10 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-white/40 uppercase tracking-widest ml-1">Revenue Actual (ETB)</label>
                        <input type="number" step="0.01" name="revenue_actual" value="{{ $update->revenue_actual }}"
                            class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-xs font-black text-emerald-400 focus:ring-4 focus:ring-emerald-500/20 focus:bg-white/10 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-white/40 uppercase tracking-widest ml-1">Target Completion Date</label>
                        <input type="date" name="completion_date" value="{{ $update->completion_date ? $update->completion_date : '' }}"
                            class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-xs font-black text-white focus:ring-4 focus:ring-emerald-500/20 focus:bg-white/10 transition-all">
                    </div>
                </div>
            </div>

            <!-- Section 3: Operational Constraints -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-10 group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">3. Operational Log</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Resource monitoring and roadblock capture</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 uppercase">Top Constraints</label>
                        <textarea name="top_constraints" rows="3" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700">{{ $update->top_constraints }}</textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 uppercase uppercase">Client Issues</label>
                        <textarea name="client_issue" rows="3" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700">{{ $update->client_issue }}</textarea>
                    </div>
                    @foreach([
                        'design_completion_approval' => 'Design Completion / Approval',
                        'material_submittal_approval' => 'Material Submittal / Approval',
                        'material_delivery' => 'Material Delivery',
                        'labor' => 'Labor',
                        'machinery_equipment' => 'Machinery / Equipment',
                        'subcontractor' => 'Subcontractor',
                        'finance' => 'Finance',
                        'operation_constraint' => 'Operation Constraint'
                    ] as $field => $label)
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 uppercase">{{ $label }}</label>
                            <textarea name="{{ $field }}" rows="3" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700">{{ $update->$field }}</textarea>
                        </div>
                    @endforeach
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
