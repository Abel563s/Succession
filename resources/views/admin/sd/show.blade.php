<x-app-layout>
    <div class="max-w-[98%] mx-auto space-y-8 pb-12">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.sd.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-all hover:shadow-md">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Succession Dashboard Details</h1>
                    <p class="text-slate-500 font-medium">Viewing strategic succession matrix: {{ $sd->title }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase {{ $sd->status == 'published' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100' }}">
                    {{ $sd->status }}
                </span>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.sd.edit', $sd) }}" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/10 flex items-center gap-2">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        Edit Dashboard
                    </a>
                @endif
            </div>
        </div>

        <!-- Dashboard Matrix Card -->
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight uppercase">Succession Development Matrix</h3>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Department: {{ $sd->department ?: 'General Organization' }}</p>
                </div>
                <i data-lucide="layers" class="w-6 h-6 text-[#00ADC5]"></i>
            </div>
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full border-collapse min-w-[1600px]">
                    <thead>
                        <tr class="bg-slate-50/30 border-b border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-400">
                            <th class="px-6 py-4 text-center w-12">No.</th>
                            <th class="px-6 py-4 text-left">Position for Succession</th>
                            <th class="px-6 py-4 text-left">Current Holder</th>
                            <th class="px-6 py-4 text-left">Candidates</th>
                            <th class="px-4 py-4 text-left">Timeline vs Target</th>
                            <th class="px-4 py-4 text-left">Key Competencies</th>
                            <th class="px-4 py-4 text-left">SD Plan Progress</th>
                            <th class="px-4 py-4 text-left">KPI & Performance</th>
                            <th class="px-4 py-4 text-left">Monitoring</th>
                            <th class="px-6 py-4 text-center">Readiness</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-[11px]">
                        @foreach($sd->items as $index => $item)
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="px-6 py-5 text-center font-bold text-slate-400">{{ $index + 1 }}</td>
                                <td class="px-6 py-5">
                                    <p class="font-black text-slate-900">{{ $item->position }}</p>
                                </td>
                                <td class="px-6 py-5 font-bold text-slate-600">{{ $item->current_holder }}</td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-400">
                                            {{ substr($item->candidates, 0, 1) }}
                                        </div>
                                        <span class="font-bold text-slate-700">{{ $item->candidates }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-5 text-slate-600 leading-relaxed font-medium">
                                    {{ $item->timeline_progress }}
                                </td>
                                <td class="px-4 py-5 text-slate-600 leading-relaxed font-medium">
                                    {{ $item->competency_progress }}
                                </td>
                                <td class="px-4 py-5 text-slate-600 leading-relaxed font-medium">
                                    {{ $item->development_progress }}
                                </td>
                                <td class="px-4 py-5 text-slate-600 leading-relaxed font-medium">
                                    {{ $item->kpi_metrics }}
                                </td>
                                <td class="px-4 py-5 text-slate-600 leading-relaxed font-medium">
                                    {{ $item->monitoring_progress }}
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $color = match($item->readiness_rating) {
                                            'Ready Now' => 'bg-emerald-500',
                                            'Ready in 6 Months' => 'bg-[#00ADC5]',
                                            'Ready in 1 Year' => 'bg-amber-500',
                                            'Needs Development' => 'bg-rose-500',
                                            'High Potential' => 'bg-indigo-500',
                                            default => 'bg-slate-400'
                                        };
                                    @endphp
                                    <span class="inline-flex px-3 py-1.5 rounded-xl text-white text-[9px] font-black uppercase tracking-tight {{ $color }} shadow-sm">
                                        {{ $item->readiness_rating }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer Card -->
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Authentication Signature</p>
                    <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100 inline-block relative z-10">
                        @if($sd->signature_path)
                            <img src="{{ asset('storage/' . $sd->signature_path) }}" class="h-20 object-contain" alt="Signature">
                        @else
                            <div class="h-20 w-48 flex items-center justify-center border-2 border-dashed border-slate-200 rounded-xl">
                                <span class="text-xs font-bold text-slate-400">No Signature Recorded</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="h-16 w-px bg-slate-100 hidden md:block"></div>
                <div>
                    <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-1">Creation Date</h4>
                    <p class="text-sm font-bold text-slate-500">{{ $sd->created_at->format('M d, Y') }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Matrix Status</p>
                <div class="flex items-center gap-2 justify-end">
                    <div class="w-2 h-2 rounded-full {{ $sd->status == 'published' ? 'bg-emerald-500' : 'bg-amber-500' }} animate-pulse"></div>
                    <span class="text-sm font-black text-slate-900 uppercase">{{ $sd->status }}</span>
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        @if(auth()->user()->isAdmin())
            <div class="bg-rose-50 rounded-[2rem] border border-rose-100 p-8 flex items-center justify-between">
                <div>
                    <h4 class="text-rose-900 font-black">Danger Zone</h4>
                    <p class="text-rose-600/70 text-sm font-medium">Permanently remove this succession dashboard from the system.</p>
                </div>
                <form action="{{ route('admin.sd.destroy', $sd) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this dashboard?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-white text-rose-600 px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-rose-600 hover:text-white transition-all shadow-sm border border-rose-100 flex items-center gap-2">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                        Delete Dashboard
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
