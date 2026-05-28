<x-app-layout>
    <div class="py-6 space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                Requirement Details <span class="text-slate-400">#{{ $requirement->tracking_id }}</span>
            </h2>
            <div class="flex gap-4">
                <a href="{{ route('admin.rebar.requirements.index') }}"
                    class="px-5 py-2.5 text-slate-600 font-bold hover:bg-slate-100 rounded-xl transition-all">Back</a>
                <a href="{{ route('admin.rebar.cutting-logs.create', ['requirement_id' => $requirement->id]) }}"
                    class="px-5 py-2.5 bg-[#D4AF37] text-white rounded-xl font-bold shadow-lg shadow-cyan-500/20 hover:bg-[#0098ad] transition-all">
                    Log Cutting
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Details Card -->
            <div class="md:col-span-1 space-y-6">
                <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Structural
                            Element</label>
                        <p class="text-xl font-black text-slate-800">{{ $requirement->structural_element }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Bar
                            Diameter</label>
                        <p class="text-lg font-bold text-slate-700">{{ $requirement->bar_diameter }}mm</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Length</label>
                            <p class="font-medium text-slate-600">{{ $requirement->required_length }}mm</p>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Quantity</label>
                            <p class="font-medium text-slate-600">{{ $requirement->quantity }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total
                            Steel</label>
                        <p class="text-2xl font-black text-[#D4AF37]">
                            {{ number_format($requirement->total_length, 2) }}m
                        </p>
                    </div>
                    @if($requirement->drawing_reference)
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Drawing
                                Ref</label>
                            <p class="font-medium text-slate-600">{{ $requirement->drawing_reference }}</p>
                        </div>
                    @endif
                    @if($requirement->remarks)
                        <div class="pt-4 border-t border-slate-100">
                            <label
                                class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Remarks</label>
                            <p class="text-sm text-slate-500 italic">"{{ $requirement->remarks }}"</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Related Cutting Logs -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="bg-slate-50/50 px-6 py-4 border-b border-slate-200">
                        <h3 class="font-bold text-slate-800">Cutting History</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-widest">
                                        Date</th>
                                    <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-widest">
                                        Original</th>
                                    <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-widest">Cut
                                    </th>
                                    <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-widest">
                                        Remaining</th>
                                    <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-widest">
                                        Off-cut</th>
                                    <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-widest">
                                        Used For</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($requirement->cuttingLogs as $log)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-3 text-sm font-medium text-slate-700">{{ $log->date }}</td>
                                        <td class="px-6 py-3 text-sm text-slate-600">{{ $log->original_length }}mm</td>
                                        <td class="px-6 py-3 text-sm font-bold text-rose-600">-{{ $log->cut_length }}mm</td>
                                        <td class="px-6 py-3 text-sm font-bold text-emerald-600">
                                            {{ $log->remaining_length }}mm
                                        </td>
                                        <td class="px-6 py-3 text-sm">
                                            @if($log->offcut)
                                                <a href="{{ route('admin.rebar.offcuts.index') }}?code={{ $log->offcut->offcut_code }}"
                                                    class="text-[#D4AF37] hover:underline font-bold text-xs">{{ $log->offcut->offcut_code }}</a>
                                            @else
                                                <span class="text-slate-300">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-3 text-sm text-slate-500">{{ $log->used_for ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-slate-400 text-sm">No cutting logs
                                            recorded yet.</td>
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