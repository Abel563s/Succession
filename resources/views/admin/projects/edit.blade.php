<x-app-layout>
    <div class="py-10 px-6 space-y-12 max-w-[1400px] mx-auto font-inter">

        <!-- Premium Header -->
        <div class="flex items-center justify-between border-b border-slate-100 pb-10">
            <div class="space-y-1">
                <a href="{{ route('admin.projects.index') }}"
                    class="text-[10px] font-black text-[#D4AF37] uppercase tracking-[0.3em] flex items-center gap-2 mb-4">
                    <i data-lucide="arrow-left" class="w-3 h-3"></i>
                    Back to Registry
                </a>
                <h2 class="text-4xl font-black text-slate-900 tracking-tight font-outfit"> <span
                        class="text-[#D4AF37]">Protocol</span></h2>
                <p class="text-slate-500 font-medium">Modify existing project asset parameters in the operational
                    matrix.</p>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" form="project-form"
                    class="px-10 py-4 bg-slate-800 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-widest shadow-2xl shadow-slate-900/20 hover:scale-105 active:scale-95 transition-all">
                    Update
                </button>
            </div>
        </div>

        <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" id="project-form"
            class="space-y-12">
            @csrf
            @method('PUT')

            <!-- Section 1: Project Identity -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-10 group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-[#D4AF37]">
                        <i data-lucide="fingerprint" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">1. Project Identity</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Core deployment
                            and categorization</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Project
                            ID</label>
                        <input type="text" disabled value="{{ $project->custom_id }}"
                            class="w-full px-6 py-4 bg-slate-100 border-none rounded-2xl text-xs font-bold text-slate-400 cursor-not-allowed">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Project
                            Code</label>
                        <input type="text" name="project_code" value="{{ $project->project_code }}" required
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2 lg:col-span-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Project
                            Name</label>
                        <input type="text" name="project_name" value="{{ $project->project_name }}" required
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Project
                            Type</label>
                        <select name="project_type" required
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all cursor-pointer">
                            <option value="Building" {{ $project->project_type == 'Building' ? 'selected' : '' }}>Building
                            </option>
                            <option value="Fit-Out" {{ $project->project_type == 'Fit-Out' ? 'selected' : '' }}>Fit-Out
                            </option>
                            <option value="Infrastructure" {{ $project->project_type == 'Infrastructure' ? 'selected' : '' }}>Infrastructure</option>
                            <option value="Mixed (Bui/Road)" {{ $project->project_type == 'Mixed (Bui/Road)' ? 'selected' : '' }}>Mixed (Bui/Road)</option>
                            <option value="Mixed (Bui/Fit-Out)" {{ $project->project_type == 'Mixed (Bui/Fit-Out)' ? 'selected' : '' }}>Mixed (Bui/Fit-Out)</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Delivery
                            Method</label>
                        <select name="delivery_method" required
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all cursor-pointer">
                            <option value="DB" {{ $project->delivery_method == 'DB' ? 'selected' : '' }}>DB</option>
                            <option value="DBB" {{ $project->delivery_method == 'DBB' ? 'selected' : '' }}>DBB</option>
                            <option value="DB-LS" {{ $project->delivery_method == 'DB-LS' ? 'selected' : '' }}>DB-LS
                            </option>
                            <option value="DB-ADM" {{ $project->delivery_method == 'DB-ADM' ? 'selected' : '' }}>DB-ADM
                            </option>
                            <option value="DBB-ADM" {{ $project->delivery_method == 'DBB-ADM' ? 'selected' : '' }}>DBB-ADM
                            </option>
                            <option value="DB-CP" {{ $project->delivery_method == 'DB-CP' ? 'selected' : '' }}>DB-CP
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 2: Stakeholders -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-10 group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">2. Stakeholders & Scope</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Partners and
                            operational boundaries</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Project
                            Client</label>
                        <input type="text" name="project_client" value="{{ $project->project_client }}"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Consultant</label>
                        <input type="text" name="consultant" value="{{ $project->consultant }}"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Consultancy
                            Sector</label>
                        <select name="consultancy_sector"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100/50 focus:bg-white transition-all cursor-pointer">
                            <option value="Government" {{ $project->consultancy_sector == 'Government' ? 'selected' : '' }}>Government</option>
                            <option value="Private" {{ $project->consultancy_sector == 'Private' ? 'selected' : '' }}>
                                Private</option>
                            <option value="Client / Engineering Team" {{ $project->consultancy_sector == 'Client / Engineering Team' ? 'selected' : '' }}>Client / Engineering Team</option>
                        </select>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Scope</label>
                    <textarea name="scope" rows="3"
                        class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100/50 focus:bg-white transition-all">{{ $project->scope }}</textarea>
                </div>
            </div>

            <!-- Section 3: Financial Matrix -->
            <div
                class="bg-slate-800 p-10 rounded-[3rem] shadow-2xl shadow-slate-900/40 space-y-10 relative overflow-hidden">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl"></div>

                <div class="flex items-center gap-4 relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-[#D4AF37]">
                        <i data-lucide="banknote" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-white tracking-tight">3. Financial Ledger</h3>
                        <p class="text-[10px] font-black text-white/40 uppercase tracking-widest mt-1">Capital
                            allocation and cost analysis (ETB)</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 relative z-10">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-white/40 uppercase tracking-widest ml-1">Contract
                            Budget</label>
                        <input type="number" step="0.01" name="contract_budget" value="{{ $project->contract_budget }}"
                            class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-xs font-black text-[#D4AF37] focus:ring-4 focus:ring-cyan-500/20 focus:bg-white/10 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label
                            class="text-[10px] font-black text-white/40 uppercase tracking-widest ml-1">Variation</label>
                        <input type="number" step="0.01" name="variation" value="{{ $project->variation }}"
                            class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-xs font-black text-[#D4AF37] focus:ring-4 focus:ring-cyan-500/20 focus:bg-white/10 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label
                            class="text-[10px] font-black text-white/40 uppercase tracking-widest ml-1">Supplementary</label>
                        <input type="number" step="0.01" name="supplementary" value="{{ $project->supplementary }}"
                            class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-xs font-black text-[#D4AF37] focus:ring-4 focus:ring-cyan-500/20 focus:bg-white/10 transition-all">
                    </div>
                    <div class="space-y-2 text-[#D4AF37]">
                        <label class="text-[10px] font-black text-white/40 uppercase tracking-widest ml-1">Total
                            Allowable Cost</label>
                        <input type="number" step="0.01" name="total_allowable_cost"
                            value="{{ $project->total_allowable_cost }}"
                            class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-xs font-black text-white focus:ring-4 focus:ring-cyan-500/20 focus:bg-white/10 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-white/40 uppercase tracking-widest ml-1">Cost At
                            Completion</label>
                        <input type="number" step="0.01" name="cost_at_completion"
                            value="{{ $project->cost_at_completion }}"
                            class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-xs font-black text-white focus:ring-4 focus:ring-cyan-500/20 focus:bg-white/10 transition-all">
                    </div>
                </div>
            </div>

            <!-- Section 4: Timeline -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">
                        <i data-lucide="calendar" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">4. Temporal States</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Schedule
                            baseline and execution data</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Baseline
                            Start Date</label>
                        <input type="date" name="baseline_start_date"
                            value="{{ $project->baseline_start_date ? $project->baseline_start_date->format('Y-m-d') : '' }}"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-amber-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Baseline
                            Finish Date</label>
                        <input type="date" name="baseline_finish_date"
                            value="{{ $project->baseline_finish_date ? $project->baseline_finish_date->format('Y-m-d') : '' }}"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-amber-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Actual Start
                            Date</label>
                        <input type="date" name="actual_start_date"
                            value="{{ $project->actual_start_date ? $project->actual_start_date->format('Y-m-d') : '' }}"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-amber-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Actual
                            Finish Date</label>
                        <input type="date" name="actual_finish_date"
                            value="{{ $project->actual_finish_date ? $project->actual_finish_date->format('Y-m-d') : '' }}"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-amber-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Approved
                            EOT</label>
                        <input type="date" name="approved_eot"
                            value="{{ $project->approved_eot ? $project->approved_eot->format('Y-m-d') : '' }}"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-amber-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Revision
                            Number</label>
                        <input type="text" name="revision_number" value="{{ $project->revision_number }}"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-amber-100/50 focus:bg-white transition-all">
                    </div>
                </div>
            </div>

            <!-- Section 5: Closeout -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <i data-lucide="check-circle" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">5. Final Archival & Status</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Operational
                            state and certificate registry</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Closing
                            Status</label>
                        <select name="closing_status"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-emerald-100/50 focus:bg-white transition-all cursor-pointer">
                            <option value="FA Received" {{ $project->closing_status == 'FA Received' ? 'selected' : '' }}>
                                FA Received</option>
                            <option value="PA Received" {{ $project->closing_status == 'PA Received' ? 'selected' : '' }}>
                                PA Received</option>
                            <option value="PPA Received" {{ $project->closing_status == 'PPA Received' ? 'selected' : '' }}>PPA Received</option>
                            <option value="Snag / Di-Snag" {{ $project->closing_status == 'Snag / Di-Snag' ? 'selected' : '' }}>Snag / Di-Snag</option>
                            <option value="Waiting for PA" {{ $project->closing_status == 'Waiting for PA' ? 'selected' : '' }}>Waiting for PA</option>
                            <option value="Not Completed" {{ $project->closing_status == 'Not Completed' ? 'selected' : '' }}>Not Completed</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">PPA
                            Received</label>
                        <input type="date" name="ppa_received_at"
                            value="{{ $project->ppa_received_at ? $project->ppa_received_at->format('Y-m-d') : '' }}"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-emerald-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">PA
                            Received</label>
                        <input type="date" name="pa_received_at"
                            value="{{ $project->pa_received_at ? $project->pa_received_at->format('Y-m-d') : '' }}"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-emerald-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">FA
                            Received</label>
                        <input type="date" name="fa_received_at"
                            value="{{ $project->fa_received_at ? $project->fa_received_at->format('Y-m-d') : '' }}"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-emerald-100/50 focus:bg-white transition-all">
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>