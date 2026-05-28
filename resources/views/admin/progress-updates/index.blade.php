<x-app-layout>
    <div class="py-10 px-6 space-y-12 max-w-[1700px] mx-auto font-inter">

        <!-- Modern Compact Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 pb-4 border-b border-slate-100">
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center text-white shadow-xl shadow-slate-900/20">
                        <i data-lucide="trending-up" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-light text-slate-400 tracking-tight font-outfit leading-none">
                            Progress <span class="font-black text-slate-900">Updates</span>
                        </h2>
                        <p class="text-[10px] font-black text-[#D4AF37] uppercase tracking-[0.3em] mt-2">Operational Performance Matrix</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2 px-6 py-3 bg-white border border-slate-100 rounded-2xl shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ $updates->count() }} Metrics Filed</span>
                </div>
                
                <a href="{{ route('admin.progress-updates.create') }}" 
                   class="group/btn relative px-8 py-3.5 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest overflow-hidden transition-all hover:scale-105 active:scale-95 shadow-xl shadow-slate-900/20">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#D4AF37] to-blue-500 translate-x-[-100%] group-hover/btn:translate-x-0 transition-transform duration-500"></div>
                    <span class="relative flex items-center gap-2">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        New Project
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
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Project</th>
                            <th class="px-6 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Planned vs Actual</th>
                            <th class="px-6 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">SPI
                                Index</th>
                            <th class="px-6 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Revenue Status</th>
                            <th class="px-6 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Last
                                Edit</th>
                            <th class="px-10 py-8 text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($updates as $update)
                            <tr class="group cursor-pointer hover:bg-[#FFF8E7]/50 transition-all duration-300"
                                onclick="window.location='{{ route('admin.progress-updates.edit', $update->id) }}'">
                                <td class="px-10 py-7">
                                    <div class="flex items-center gap-5">
                                        <div
                                            class="w-14 h-14 rounded-2xl bg-white border-2 border-slate-50 flex items-center justify-center font-black text-xs text-slate-300 group-hover:border-[#D4AF37] group-hover:text-[#D4AF37] transition-all">
                                            {{ substr($update->project->project_name, 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-900 leading-tight">
                                                {{ $update->project->project_name }}</p>
                                            <p class="text-[10px] font-black text-[#D4AF37] uppercase tracking-widest mt-1">
                                                {{ $update->project->custom_id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-7">
                                    <div class="space-y-1">
                                        <div
                                            class="flex justify-between text-[10px] font-black uppercase tracking-widest mb-1">
                                            <span class="text-slate-400">Progress</span>
                                            <span class="text-[#D4AF37]">{{ $update->progress_actual }}% /
                                                {{ $update->progress_planned }}%</span>
                                        </div>
                                        <div class="w-48 h-2 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-[#D4AF37] rounded-full"
                                                style="width: {{ min(100, $update->progress_actual) }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-7">
                                    @php
                                        $spi = $update->progress_planned > 0 ? ($update->progress_actual / $update->progress_planned) : 0;
                                        $spiColor = $spi >= 1 ? 'text-emerald-500' : ($spi >= 0.8 ? 'text-amber-500' : 'text-rose-500');
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="text-lg font-black {{ $spiColor }}">{{ number_format($spi * 100, 1) }}%</span>
                                        <i data-lucide="{{ $spi >= 1 ? 'trending-up' : 'trending-down' }}"
                                            class="w-4 h-4 {{ $spiColor }}"></i>
                                    </div>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tight">Schedule
                                        Performance Index</p>
                                </td>
                                <td class="px-6 py-7">
                                    <p class="text-xs font-mono font-black text-slate-900">Actual:
                                        {{ number_format($update->revenue_actual) }}</p>
                                    <p class="text-[10px] font-black text-slate-400 mt-1 uppercase tracking-widest">Planned:
                                        {{ number_format($update->revenue_planned) }}</p>
                                </td>
                                <td class="px-6 py-7 text-xs font-black text-slate-400 uppercase tracking-widest">
                                    {{ $update->updated_at->format('M d, Y') }}
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
                                        <div
                                            class="w-20 h-20 rounded-[2.5rem] bg-slate-50 flex items-center justify-center">
                                            <i data-lucide="trending-up" class="w-10 h-10"></i>
                                        </div>
                                        <h3 class="text-xl font-black text-slate-900">No Record Found</h3>
                                        <p class="text-xs uppercase font-black tracking-widest text-slate-400">Please
                                            initiate a progress protocol update.</p>
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