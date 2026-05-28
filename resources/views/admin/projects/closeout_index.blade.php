<x-app-layout>
    <div class="py-10 px-6 space-y-12 max-w-[1700px] mx-auto font-inter">

        <!-- Modern Compact Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 pb-4 border-b border-slate-100">
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center text-white shadow-xl shadow-slate-900/20">
                        <i data-lucide="archive" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-light text-slate-400 tracking-tight font-outfit leading-none">
                            Project <span class="font-black text-slate-900">Closeout</span>
                        </h2>
                        <p class="text-[10px] font-black text-[#D4AF37] uppercase tracking-[0.3em] mt-2">Final Protocol
                            Reconciliation</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- Status badge removed -->
            </div>
        </div>

        <!-- Selection Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($projects as $project)
                <a href="{{ route('admin.projects.closeout.show', $project->id) }}"
                    class="group bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-amber-100 hover:-translate-y-2 transition-all duration-500 relative overflow-hidden">
                    <div
                        class="absolute -right-10 -top-10 w-32 h-32 bg-[#D4AF37]/5 rounded-full blur-3xl group-hover:bg-[#D4AF37]/10 transition-colors">
                    </div>

                    <div class="relative z-10 space-y-6">
                        <div class="flex items-center justify-between">
                            <div
                                class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center font-black text-xs text-[#D4AF37] border border-slate-100 group-hover:border-[#D4AF37]/30 group-hover:bg-white transition-all">
                                {{ $project->project_code }}
                            </div>
                            <span
                                class="px-3 py-1 bg-slate-50 text-slate-400 rounded-lg text-[10px] font-black uppercase tracking-widest group-hover:bg-amber-50 group-hover:text-[#D4AF37] transition-all">{{ $project->custom_id }}</span>
                        </div>

                        <div>
                            <h3
                                class="text-xl font-black text-slate-900 leading-tight group-hover:text-[#D4AF37] transition-colors">
                                {{ $project->project_name }}
                            </h3>
                            <p class="text-xs font-medium text-slate-400 mt-2 flex items-center gap-2">
                                <i data-lucide="building" class="w-3 h-3"></i>
                                {{ $project->project_client }}
                            </p>
                        </div>

                        <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Completion</p>
                                <p class="text-sm font-black text-slate-900">
                                    {{ number_format($project->physical_completion_percent) }}%
                                </p>
                            </div>
                            <div
                                class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 group-hover:bg-[#D4AF37] group-hover:text-white transition-all">
                                <i data-lucide="chevron-right" class="w-5 h-5"></i>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-32 text-center text-slate-400 bg-white rounded-[3rem] border border-slate-50">
                    <div class="flex flex-col items-center gap-4">
                        <div class="w-20 h-20 rounded-[2.5rem] bg-slate-50 flex items-center justify-center">
                            <i data-lucide="database" class="w-10 h-10"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">No Projects Found</h3>
                        <p class="text-xs uppercase font-black tracking-widest text-slate-400">Initialize a project to begin
                            closeout protocols.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>