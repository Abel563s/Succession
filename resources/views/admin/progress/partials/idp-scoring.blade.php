@if(isset($progress) && $progress->idpObjectives->isNotEmpty())
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
            <h2 class="text-lg font-black text-slate-800 flex items-center gap-2 uppercase tracking-tight">
                <i data-lucide="bar-chart-2" class="w-5 h-5 text-[#D4AF37]"></i>
                Progress Tracking (IDP) — Scoring
            </h2>
            @if($progress->development_id)
                <p class="text-xs text-slate-500 mt-2 font-medium">Linked to Development Plan #{{ $progress->development_id }}</p>
            @endif
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <th class="px-4 py-3 text-center w-12">#</th>
                        <th class="px-4 py-3 text-left">Objective</th>
                        <th class="px-4 py-3 text-left">Activity</th>
                        <th class="px-4 py-3 text-left">Timeline</th>
                        <th class="px-4 py-3 text-center w-28">Score</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($progress->idpObjectives->sortBy('row_number') as $objective)
                        <tr>
                            <td class="px-4 py-4 text-center font-black text-[#D4AF37]">{{ $objective->row_number }}</td>
                            <td class="px-4 py-4 text-xs font-medium text-slate-700">{{ $objective->objective }}</td>
                            <td class="px-4 py-4 text-xs text-slate-500">{{ $objective->activity }}</td>
                            <td class="px-4 py-4 text-[10px] font-bold text-slate-500">
                                {{ $objective->start_date?->format('M d, Y') }} → {{ $objective->delivery_date?->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-4">
                                <input type="text" name="idp_objectives[{{ $objective->id }}][score]"
                                       value="{{ old('idp_objectives.'.$objective->id.'.score', $objective->score) }}"
                                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-center text-xs font-black text-slate-900 focus:border-[#D4AF37] outline-none"
                                       placeholder="Score">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
