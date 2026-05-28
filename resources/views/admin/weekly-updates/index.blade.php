<x-app-layout>
    <div class="py-10 px-6 space-y-12 max-w-[1700px] mx-auto font-inter">
        
        <!-- Modern Compact Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 pb-4 border-b border-slate-100">
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center text-white shadow-xl shadow-slate-900/20">
                        <i data-lucide="calendar-days" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-light text-slate-400 tracking-tight font-outfit leading-none">
                            Weekly <span class="font-black text-slate-900">Closing Update</span>
                        </h2>
                        <p class="text-[10px] font-black text-[#D4AF37] uppercase tracking-[0.3em] mt-2">Operational Reconnaissance Matrix</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2 px-6 py-3 bg-white border border-slate-100 rounded-2xl shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ $updates->count() }} Reports Filed</span>
                </div>
                
                <a href="{{ route('admin.weekly-updates.create') }}" 
                   class="group/btn relative px-8 py-3.5 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest overflow-hidden transition-all hover:scale-105 active:scale-95 shadow-xl shadow-slate-900/20">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#D4AF37] to-blue-500 translate-x-[-100%] group-hover/btn:translate-x-0 transition-transform duration-500"></div>
                    <span class="relative flex items-center gap-2">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        New Review
                    </span>
                </a>
            </div>
        </div>

        <!-- Registry Table -->
        <div class="bg-white rounded-[3rem] shadow-sm border border-slate-50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Deployment</th>
                            <th class="px-6 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Contact Person</th>
                            <th class="px-6 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Responsible</th>
                            <th class="px-6 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Expected Completion</th>
                            <th class="px-6 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Timestamp</th>
                            <th class="px-10 py-8 text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($updates as $update)
                            <tr class="group cursor-pointer hover:bg-[#FFF8E7]/50 transition-all duration-300" onclick="window.location='{{ route('admin.weekly-updates.edit', $update->id) }}'">
                                <td class="px-10 py-7">
                                    <div class="flex items-center gap-5">
                                        <div class="w-14 h-14 rounded-2xl bg-white border-2 border-slate-50 flex items-center justify-center font-black text-xs text-slate-300 group-hover:border-[#D4AF37] group-hover:text-[#D4AF37] transition-all">
                                            <i data-lucide="file-text" class="w-6 h-6"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-900 leading-tight">{{ $update->project->project_name }}</p>
                                            <p class="text-[10px] font-black text-[#D4AF37] uppercase tracking-widest mt-1">{{ $update->project->custom_id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-7">
                                    <p class="text-xs font-black text-slate-900">{{ $update->contact_person ?? 'N/A' }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tight">Client Contact</p>
                                </td>
                                <td class="px-6 py-7">
                                    <p class="text-xs font-black text-slate-900">{{ $update->responsible_person ?? 'N/A' }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tight">Project Owner</p>
                                </td>
                                <td class="px-6 py-7">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="calendar" class="w-4 h-4 text-[#D4AF37]"></i>
                                        <p class="text-xs font-black text-slate-700">{{ $update->expected_completion_date ? $update->expected_completion_date->format('M d, Y') : '---' }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-7 text-xs font-black text-slate-400 uppercase tracking-widest">
                                    {{ $update->created_at->format('W, Y') }} (Week)
                                </td>
                                <td class="px-10 py-7 text-right">
                                    <button class="p-3 text-slate-200 group-hover:text-[#D4AF37] transition-all">
                                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-10 py-32 text-center text-slate-400">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="w-20 h-20 rounded-[2.5rem] bg-slate-50 flex items-center justify-center">
                                            <i data-lucide="calendar-days" class="w-10 h-10"></i>
                                        </div>
                                        <h3 class="text-xl font-black text-slate-900">Empty Logs</h3>
                                        <p class="text-xs uppercase font-black tracking-widest text-slate-400">No weekly reconnaissance reports filed yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
