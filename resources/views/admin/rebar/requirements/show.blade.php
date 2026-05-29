<x-app-layout>
    <div class="max-w-6xl mx-auto space-y-8 pb-12">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.rebar.requirements.index') }}"
                    class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-all hover:shadow-md">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Requirement Details</h1>
                    <p class="text-slate-500 font-medium">Tracking ID #{{ $requirement->tracking_id }} &mdash; {{ $requirement->structural_element }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.rebar.cutting-logs.create', ['requirement_id' => $requirement->id]) }}"
                    class="show-page-edit-btn">
                    <i data-lucide="scissors" class="w-4 h-4"></i>
                    Log Cutting
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Details Card -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8 space-y-6 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#00ADC5]/5 rounded-full blur-3xl"></div>

                    <div class="relative">
                        <span class="text-[9px] font-black uppercase text-slate-400 tracking-widest">Structural Element</span>
                        <p class="text-xl font-black text-slate-900 mt-1">{{ $requirement->structural_element }}</p>
                    </div>
                    <div class="relative">
                        <span class="text-[9px] font-black uppercase text-slate-400 tracking-widest">Bar Diameter</span>
                        <p class="text-lg font-bold text-slate-700 mt-1">{{ $requirement->bar_diameter }}mm</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4 relative">
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-[9px] font-black uppercase text-slate-400 tracking-tight">Length</span>
                            <p class="text-sm font-bold text-slate-700 mt-1">{{ $requirement->required_length }}mm</p>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-[9px] font-black uppercase text-slate-400 tracking-tight">Quantity</span>
                            <p class="text-sm font-bold text-slate-700 mt-1">{{ $requirement->quantity }}</p>
                        </div>
                    </div>
                    <div class="p-4 rounded-2xl bg-[#F0FDFF] border border-[#BEEAF0] relative">
                        <span class="text-[9px] font-black uppercase text-[#00515f] tracking-widest">Total Steel</span>
                        <p class="text-2xl font-black text-[#00515f] mt-1">
                            {{ number_format($requirement->total_length, 2) }}m
                        </p>
                    </div>
                    @if($requirement->drawing_reference)
                        <div class="relative">
                            <span class="text-[9px] font-black uppercase text-slate-400 tracking-widest">Drawing Ref</span>
                            <p class="text-sm font-bold text-slate-700 mt-1">{{ $requirement->drawing_reference }}</p>
                        </div>
                    @endif
                    @if($requirement->remarks)
                        <div class="pt-4 border-t border-slate-100 relative">
                            <span class="text-[9px] font-black uppercase text-slate-400 tracking-widest">Remarks</span>
                            <p class="text-sm text-slate-600 font-medium mt-1 italic">"{{ $requirement->remarks }}"</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Related Cutting Logs -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="text-lg font-black text-slate-900 tracking-tight">Cutting History</h3>
                        <i data-lucide="history" class="w-5 h-5 text-[#00515f]"></i>
                    </div>
                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gradient-to-r from-[#111111] to-[#00333B] text-white text-[10px] font-black uppercase tracking-widest">
                                    <th class="px-6 py-4 border-b border-white/5">Date</th>
                                    <th class="px-6 py-4 border-b border-white/5">Original</th>
                                    <th class="px-6 py-4 border-b border-white/5">Cut</th>
                                    <th class="px-6 py-4 border-b border-white/5">Remaining</th>
                                    <th class="px-6 py-4 border-b border-white/5">Off-cut</th>
                                    <th class="px-6 py-4 border-b border-white/5">Used For</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($requirement->cuttingLogs as $log)
                                    <tr class="hover:bg-slate-50/50 transition-colors text-sm">
                                        <td class="px-6 py-4 font-bold text-slate-700">{{ $log->date }}</td>
                                        <td class="px-6 py-4 text-slate-600">{{ $log->original_length }}mm</td>
                                        <td class="px-6 py-4 font-bold text-red-600">-{{ $log->cut_length }}mm</td>
                                        <td class="px-6 py-4 font-bold text-green-600">{{ $log->remaining_length }}mm</td>
                                        <td class="px-6 py-4">
                                            @if($log->offcut)
                                                <a href="{{ route('admin.rebar.offcuts.index') }}?code={{ $log->offcut->offcut_code }}"
                                                    class="text-[#00515f] hover:underline font-bold text-xs">{{ $log->offcut->offcut_code }}</a>
                                            @else
                                                <span class="text-slate-300">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-slate-500">{{ $log->used_for ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-16 text-center text-slate-400 font-medium italic">No cutting logs recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
