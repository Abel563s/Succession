<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-8 pb-12">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.progress.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-all hover:shadow-md">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Progress Review Details</h1>
                    <p class="text-slate-500 font-medium">Viewing performance review for {{ $progress->candidate_name }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase {{ $progress->status == 'completed' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100' }}">
                    {{ $progress->status }}
                </span>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.progress.edit', $progress) }}" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/10 flex items-center gap-2">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        Edit Review
                    </a>
                @endif
            </div>
        </div>
        <x-hr-approval-banner :record="$progress" module="progress" />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Profile -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8 text-center relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#00ADC5]/5 rounded-full blur-3xl"></div>
                    
                    <div class="w-20 h-20 rounded-3xl bg-[#00ADC5]/10 flex items-center justify-center font-black text-2xl text-[#00ADC5] mx-auto mb-6 border border-[#00ADC5]/20 relative z-10">
                        {{ substr($progress->candidate_name, 0, 1) }}
                    </div>
                    
                    <h2 class="text-xl font-black text-slate-900 mb-1 leading-tight relative z-10">{{ $progress->candidate_name }}</h2>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-6 relative z-10">Performance Review</p>

                    <div class="w-full space-y-3 relative z-10">
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col items-start">
                            <span class="text-[9px] font-black uppercase text-slate-400 tracking-tight mb-1">Department</span>
                            <span class="text-sm font-bold text-slate-700">{{ $progress->department }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col items-start">
                            <span class="text-[9px] font-black uppercase text-slate-400 tracking-tight mb-1">Line Manager</span>
                            <span class="text-sm font-bold text-slate-700">{{ $progress->line_manager }}</span>
                        </div>
                    </div>
                </div>

                <!-- Skill Summary -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6 space-y-6">
                    <div>
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 flex items-center gap-2">
                            <i data-lucide="award" class="w-3.5 h-3.5 text-emerald-500"></i>
                            New Competencies
                        </h4>
                        <p class="text-xs font-bold text-slate-600 leading-relaxed">{{ $progress->new_competencies ?: 'None documented.' }}</p>
                    </div>
                    <div class="pt-6 border-t border-slate-100">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 flex items-center gap-2">
                            <i data-lucide="alert-triangle" class="w-3.5 h-3.5 text-rose-500"></i>
                            Gaps Identified
                        </h4>
                        <p class="text-xs font-bold text-slate-600 leading-relaxed">{{ $progress->gaps_identified ?: 'None documented.' }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Performance Summary -->
                <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="text-lg font-black text-slate-900 tracking-tight">Performance Summary</h3>
                        <i data-lucide="clipboard-check" class="w-5 h-5 text-[#00ADC5]"></i>
                    </div>
                    <div class="p-8">
                        <div class="p-6 rounded-3xl bg-slate-50 border border-slate-100 text-slate-600 font-medium text-sm leading-relaxed whitespace-pre-wrap">
                            {{ $progress->performance_summary ?: 'No summary provided.' }}
                        </div>
                    </div>
                </div>

                <!-- Progress Tracking Table -->
                <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="text-lg font-black text-slate-900 tracking-tight">Progress Tracking (IDP)</h3>
                        <i data-lucide="activity" class="w-5 h-5 text-[#00ADC5]"></i>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-slate-50/30 border-b border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                    <th class="px-8 py-4 text-left">Date</th>
                                    <th class="px-4 py-4 text-left">Achievements</th>
                                    <th class="px-4 py-4 text-left">Challenges</th>
                                    <th class="px-8 py-4 text-left">Next Steps</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($progress->trackingItems as $item)
                                    <tr>
                                        <td class="px-8 py-5 text-xs font-black text-slate-900 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($item->review_date)->format('M d, Y') }}
                                        </td>
                                        <td class="px-4 py-5 text-xs font-medium text-slate-600 leading-relaxed">
                                            {{ $item->achievements }}
                                        </td>
                                        <td class="px-4 py-5 text-xs font-medium text-slate-600 leading-relaxed">
                                            {{ $item->challenges }}
                                        </td>
                                        <td class="px-8 py-5 text-xs font-bold text-slate-700 leading-relaxed">
                                            {{ $item->next_steps }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Updated Action Plan -->
                <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="text-lg font-black text-slate-900 tracking-tight">Updated Action Plan</h3>
                        <i data-lucide="trending-up" class="w-5 h-5 text-[#00ADC5]"></i>
                    </div>
                    <div class="p-8">
                        <div class="p-6 rounded-3xl bg-indigo-50/30 border border-indigo-100 text-slate-600 font-medium text-sm leading-relaxed whitespace-pre-wrap italic">
                            "{{ $progress->updated_action_plan ?: 'No action plan documented.' }}"
                        </div>
                    </div>
                </div>

                <!-- Signature Card -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Verification Signature</p>
                        <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100 inline-block relative z-10">
                            @if($progress->signature_path)
                                <img src="{{ \App\Support\StorageUrl::public($progress->signature_path) }}" class="h-20 object-contain" alt="Signature">
                            @else
                                <div class="h-20 w-48 flex items-center justify-center border-2 border-dashed border-slate-200 rounded-xl">
                                    <span class="text-xs font-bold text-slate-400">No Signature Recorded</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-black text-slate-900 mb-1">Digitally Signed By</p>
                        <p class="text-sm font-medium text-slate-500 italic">{{ $progress->line_manager }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
