<x-app-layout>
    <div class="py-10 px-6 space-y-12 max-w-[1200px] mx-auto font-inter">

        <!-- Premium Header -->
        <div class="flex items-center justify-between border-b border-slate-100 pb-10">
            <div class="space-y-1">
                <a href="{{ route('admin.weekly-updates.index') }}"
                    class="text-[10px] font-black text-[#D4AF37] uppercase tracking-[0.3em] flex items-center gap-2 mb-4">
                    <i data-lucide="arrow-left" class="w-3 h-3"></i>
                    Back to Closing
                </a>
                <h2 class="text-4xl font-black text-slate-900 tracking-tight font-outfit">Weekly Closing <span
                        class="text-[#D4AF37]">Update</span></h2>
                <p class="text-slate-500 font-medium">Generate a comprehensive weekly reconnaissance report for closing
                    projects
                </p>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" form="weekly-form"
                    class="px-10 py-4 bg-[#D4AF37] text-white rounded-[1.5rem] font-black text-xs uppercase tracking-widest shadow-2xl shadow-cyan-200 hover:scale-105 active:scale-95 transition-all">
                    Update
                </button>
            </div>
        </div>

        <form action="{{ route('admin.weekly-updates.store') }}" method="POST" id="weekly-form" class="space-y-12">
            @csrf

            <!-- Section 1: Asset Information -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-[#D4AF37]">
                        <i data-lucide="briefcase" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">1. Project </h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Select the
                            project for weekly update</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Project
                            Name</label>
                        <select name="project_id" required
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all cursor-pointer">
                            <option value="">Select a Project...</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->project_name }}
                                    ({{ $project->project_code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Contact
                            Person (Client Side)</label>
                        <input type="text" name="contact_person"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Responsible
                            Person (Internal)</label>
                        <input type="text" name="responsible_person"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all">
                    </div>
                </div>
            </div>

            <!-- Section 2: Operational Status -->
            <div
                class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-10 relative overflow-hidden">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-amber-500/5 rounded-full blur-3xl"></div>
                <div class="flex items-center gap-4 relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-[#D4AF37]">
                        <i data-lucide="activity" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">2. Reconnaissance Logic</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Current state
                            and
                            future projections</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                    <div class="space-y-2">
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 text-emerald-500">Current
                            Status</label>
                        <textarea name="status" rows="4"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all"></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Activities
                            Planned for Next Week</label>
                        <textarea name="activity_planned_next_week" rows="4"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all"></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Remaining
                            Items</label>
                        <textarea name="remaining_items" rows="4"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all"></textarea>
                    </div>

                    <div class="space-y-2">
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 text-rose-500">Constraints
                            & Roadblocks</label>
                        <textarea name="constraints" rows="4"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-rose-100/50 focus:bg-white transition-all"></textarea>
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Expected
                            Completion Date</label>
                        <input type="date" name="expected_completion_date"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-black text-slate-700 focus:ring-4 focus:ring-cyan-100/50 focus:bg-white transition-all">
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>