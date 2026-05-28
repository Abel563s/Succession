<x-app-layout>
    <div class="py-10 px-6 space-y-12 max-w-[1400px] mx-auto font-inter">

        <!-- Modern Compact Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 pb-4 border-b border-slate-100">
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.projects.index') }}"
                        class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-[#D4AF37] hover:border-[#D4AF37]/20 hover:rotate-[-10deg] transition-all shadow-sm">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>
                    <div>
                        <h2 class="text-3xl font-light text-slate-400 tracking-tight font-outfit leading-none">
                            Deploy <span class="font-black text-slate-900">Project</span>
                        </h2>
                        <p class="text-[10px] font-black text-[#D4AF37] uppercase tracking-[0.3em] mt-2">Initialize
                            Architecture Protocol</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- Protocol version removed -->

                <button type="submit" form="project-form"
                    class="group/btn relative px-10 py-3.5 bg-slate-900 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest overflow-hidden transition-all hover:scale-105 active:scale-95 shadow-xl shadow-slate-900/20">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-[#D4AF37] to-blue-500 translate-x-[-100%] group-hover/btn:translate-x-0 transition-transform duration-500">
                    </div>
                    <span class="relative flex items-center gap-2">
                        <i data-lucide="rocket" class="w-4 h-4"></i>
                        Create Project
                    </span>
                </button>
            </div>
        </div>

        <form action="{{ route('admin.projects.store') }}" method="POST" id="project-form" class="space-y-12">
            @csrf

            <!-- Section 1: Project Identity -->
            <div
                class="bg-white p-10 rounded-[3rem] shadow-xl shadow-slate-200/60 border border-slate-50 space-y-10 group/section hover:shadow-2xl hover:shadow-[#D4AF37]/10 transition-all duration-500 relative overflow-hidden">
                <div
                    class="absolute -right-20 -top-20 w-64 h-64 bg-amber-50/50 rounded-full blur-3xl group-hover/section:bg-cyan-100/50 transition-all duration-700">
                </div>
                <div class="flex items-center gap-4 relative z-10">
                    <div
                        class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-[#D4AF37] group-hover/section:scale-110 transition-transform duration-500">
                        <i data-lucide="fingerprint" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">1. Project Identity</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Core deployment
                            and categorization</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 relative z-10">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Project ID
                            (Auto)</label>
                        <input type="text" disabled placeholder="PRJ-XXXX"
                            class="w-full px-6 py-4 bg-slate-100 border-none rounded-2xl text-xs font-bold text-slate-400 cursor-not-allowed">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Project
                            Code</label>
                        <input type="text" name="project_code" required
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2 lg:col-span-1">
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 text-[#D4AF37]">Project
                            Name</label>
                        <input type="text" name="project_name" required
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Project
                            Type</label>
                        <select name="project_type" required
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all cursor-pointer">
                            <option value="Building">Building</option>
                            <option value="Fit-Out">Fit-Out</option>
                            <option value="Infrastructure">Infrastructure</option>
                            <option value="Mixed (Bui/Road)">Mixed (Bui/Road)</option>
                            <option value="Mixed (Bui/Fit-Out)">Mixed (Bui/Fit-Out)</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Delivery
                            Method</label>
                        <select name="delivery_method" required
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all cursor-pointer">
                            <option value="DB">DB</option>
                            <option value="DBB">DBB</option>
                            <option value="DB-LS">DB-LS</option>
                            <option value="DB-ADM">DB-ADM</option>
                            <option value="DBB-ADM">DBB-ADM</option>
                            <option value="DB-CP">DB-CP</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 2: Stakeholders -->
            <div
                class="bg-white p-10 rounded-[3rem] shadow-xl shadow-slate-200/60 border border-slate-50 space-y-10 group/section hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500 relative overflow-hidden">
                <div
                    class="absolute -left-20 -bottom-20 w-64 h-64 bg-indigo-50/50 rounded-full blur-3xl group-hover/section:bg-indigo-100/50 transition-all duration-700">
                </div>
                <div class="flex items-center gap-4 relative z-10">
                    <div
                        class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover/section:rotate-12 transition-transform duration-500">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">2. Stakeholders & Scope</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Partners and
                            operational boundaries</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Project
                            Client</label>
                        <input type="text" name="project_client"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Consultant</label>
                        <input type="text" name="consultant"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Consultancy
                            Sector</label>
                        <select name="consultancy_sector"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100/50 focus:bg-white transition-all cursor-pointer">
                            <option value="Government">Government</option>
                            <option value="Private">Private</option>
                            <option value="Client / Engineering Team">Client / Engineering Team</option>
                        </select>
                    </div>
                </div>
                <div class="space-y-2 relative z-10">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Scope</label>
                    <textarea name="scope" rows="3"
                        class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100/50 focus:bg-white transition-all"></textarea>
                </div>
            </div>

            <!-- Section 3: Financial Matrix (Lightened and Popped) -->
            <div
                class="bg-white p-10 rounded-[3rem] shadow-2xl shadow-[#D4AF37]/10 border border-[#D4AF37]/10 space-y-10 group/section hover:shadow-2xl hover:shadow-[#D4AF37]/20 transition-all duration-500 relative overflow-hidden">
                <div
                    class="absolute -right-20 -top-20 w-80 h-80 bg-[#D4AF37]/5 rounded-full blur-3xl group-hover/section:scale-110 transition-all duration-1000">
                </div>

                <div class="flex items-center gap-4 relative z-10">
                    <div
                        class="w-12 h-12 rounded-2xl bg-[#e6f7fa] flex items-center justify-center text-[#D4AF37] group-hover/section:animate-pulse">
                        <i data-lucide="banknote" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">3. Financial Ledger</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Capital
                            allocation and cost analysis (ETB)</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 relative z-10">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Contract
                            Budget</label>
                        <input type="number" step="0.01" name="contract_budget"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-black text-slate-900 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Variation</label>
                        <input type="number" step="0.01" name="variation"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-black text-slate-900 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Supplementary</label>
                        <input type="number" step="0.01" name="supplementary"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-black text-slate-900 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 text-[#D4AF37]">Total
                            Allowable Cost</label>
                        <input type="number" step="0.01" name="total_allowable_cost"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-black text-slate-900 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Cost At
                            Completion</label>
                        <input type="number" step="0.01" name="cost_at_completion"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-black text-slate-900 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all">
                    </div>
                </div>
            </div>

            <!-- Section 4: Timeline -->
            <div
                class="bg-white p-10 rounded-[3rem] shadow-xl shadow-slate-200/60 border border-slate-50 space-y-10 group/section hover:shadow-2xl hover:shadow-amber-500/10 transition-all duration-500 relative overflow-hidden">
                <div
                    class="absolute -right-20 -top-20 w-64 h-64 bg-amber-50/50 rounded-full blur-3xl group-hover/section:bg-amber-100/50 transition-all duration-700">
                </div>
                <div class="flex items-center gap-4 relative z-10">
                    <div
                        class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover/section:scale-110 transition-all duration-500">
                        <i data-lucide="calendar" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">4. Project States</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Schedule
                            baseline and execution data</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 relative z-10">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Baseline
                            Start Date</label>
                        <input type="date" name="baseline_start_date"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-amber-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Baseline
                            Finish Date</label>
                        <input type="date" name="baseline_finish_date"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-amber-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Actual Start
                            Date</label>
                        <input type="date" name="actual_start_date"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-amber-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Actual
                            Finish Date</label>
                        <input type="date" name="actual_finish_date"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-amber-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Approved
                            EOT</label>
                        <input type="date" name="approved_eot"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-amber-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Revision
                            Number</label>
                        <input type="text" name="revision_number"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-amber-100/50 focus:bg-white transition-all">
                    </div>
                </div>
            </div>

            <!-- Section 5: Closeout -->
            <div
                class="bg-white p-10 rounded-[3rem] shadow-xl shadow-slate-200/60 border border-slate-50 space-y-10 group/section hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-500 relative overflow-hidden">
                <div
                    class="absolute -right-20 -top-20 w-64 h-64 bg-emerald-50/50 rounded-full blur-3xl group-hover/section:bg-emerald-100/50 transition-all duration-700">
                </div>
                <div class="flex items-center gap-4 relative z-10">
                    <div
                        class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover/section:rotate-6 transition-all duration-500">
                        <i data-lucide="check-circle" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">5. Final Archival & Status</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Operational
                            state and certificate registry</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative z-10">
                    <div class="space-y-2">
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 text-emerald-500">Closing
                            Status</label>
                        <select name="closing_status"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-emerald-100/50 focus:bg-white transition-all cursor-pointer">
                            <option value="FA Received">FA Received</option>
                            <option value="PA Received">PA Received</option>
                            <option value="PPA Received">PPA Received</option>
                            <option value="Snag / Di-Snag">Snag / Di-Snag</option>
                            <option value="Waiting for PA">Waiting for PA</option>
                            <option value="Not Completed">Not Completed</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">PPA
                            Received</label>
                        <input type="date" name="ppa_received_at"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-emerald-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">PA
                            Received</label>
                        <input type="date" name="pa_received_at"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-emerald-100/50 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">FA
                            Received</label>
                        <input type="date" name="fa_received_at"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-emerald-100/50 focus:bg-white transition-all">
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>