<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-8 pb-12">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.leadership.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-all hover:shadow-md">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Assessment Details</h1>
                    <p class="text-slate-500 font-medium">Viewing leadership competency evaluation for {{ $leadership->candidate_name }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase {{ $leadership->status == 'published' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100' }}">
                    {{ $leadership->status }}
                </span>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.leadership.edit', $leadership) }}" class="show-page-edit-btn">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        Edit Assessment
                    </a>
                @endif
            </div>
        </div>
        <x-hr-approval-banner :record="$leadership" module="leadership" />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Profile & Score -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8 text-center relative overflow-hidden">
                    <x-record-avatar :name="$leadership->candidate_name" class="mx-auto mb-6 relative z-10" />
                    
                    <h2 class="text-xl font-black text-slate-900 mb-1 leading-tight relative z-10">{{ $leadership->candidate_name }}</h2>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-8 relative z-10">{{ $leadership->department }}</p>

                    <div class="space-y-4 mb-8 relative z-10">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col items-center">
                            <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Overall Leadership Score</span>
                            <span class="text-3xl font-black text-[#D4AF37]">{{ number_format($leadership->overall_score, 1) }}<span class="text-sm text-slate-300 ml-1">/ 5.0</span></span>
                        </div>
                    </div>

                    <div class="w-full space-y-3 relative z-10 text-left">
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col items-start">
                            <span class="text-[9px] font-black uppercase text-slate-400 tracking-tight mb-1">Line Manager</span>
                            <span class="text-sm font-bold text-slate-700">{{ $leadership->line_manager }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col items-start">
                            <span class="text-[9px] font-black uppercase text-slate-400 tracking-tight mb-1">Assessment Date</span>
                            <span class="text-sm font-bold text-slate-700">{{ $leadership->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Readiness Indicator -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6 text-center">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Leadership Readiness</h4>
                    @php
                        $readiness = match(true) {
                            $leadership->overall_score >= 4.5 => ['High Potential', 'bg-emerald-500'],
                            $leadership->overall_score >= 3.5 => ['Ready for Growth', 'bg-[#D4AF37]'],
                            $leadership->overall_score >= 2.5 => ['Developing', 'bg-amber-500'],
                            default => ['Needs Improvement', 'bg-rose-500']
                        };
                    @endphp
                    <div class="inline-flex px-6 py-2 rounded-xl text-white text-xs font-black uppercase tracking-widest {{ $readiness[1] }} shadow-lg shadow-current/20">
                        {{ $readiness[0] }}
                    </div>
                </div>
            </div>

            <!-- Right Column: Ratings & Feedback -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Competency Breakdown -->
                <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="text-lg font-black text-slate-900 tracking-tight">Competency Breakdown</h3>
                        <i data-lucide="bar-chart-2" class="w-5 h-5 text-[#D4AF37]"></i>
                    </div>
                    <div class="p-8 space-y-6">
                        @foreach($leadership->ratings as $rating)
                            <div class="space-y-2">
                                <div class="flex justify-between items-end">
                                    <span class="text-sm font-black text-slate-700">{{ $rating->competency_name }}</span>
                                    <span class="text-xs font-black text-[#D4AF37]">{{ $rating->rating }} / 5</span>
                                </div>
                                <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#D4AF37] rounded-full" style="width: {{ ($rating->rating / 5) * 100 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Comments & Observations -->
                <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="text-lg font-black text-slate-900 tracking-tight">Manager Observations</h3>
                        <i data-lucide="message-square" class="w-5 h-5 text-[#D4AF37]"></i>
                    </div>
                    <div class="p-8">
                        <div class="p-6 rounded-3xl bg-slate-50 border border-slate-100 text-slate-600 font-medium text-sm leading-relaxed whitespace-pre-wrap italic">
                            "{{ $leadership->comments ?: 'No additional feedback recorded.' }}"
                        </div>
                    </div>
                </div>

                <!-- Signature & Verification -->
                <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Manager Signature</p>
                        <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100 inline-block relative z-10">
                            @if($leadership->signature_path)
                                <img src="{{ \App\Support\StorageUrl::public($leadership->signature_path) }}" class="h-20 object-contain" alt="Signature">
                            @else
                                <div class="h-20 w-48 flex items-center justify-center border-2 border-dashed border-slate-200 rounded-xl">
                                    <span class="text-xs font-bold text-slate-400">No Signature Recorded</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-black text-slate-900 mb-1">Authenticated By</p>
                        <p class="text-sm font-medium text-slate-500 italic">{{ $leadership->line_manager }}</p>
                        <p class="text-[9px] font-bold text-slate-400 mt-2">DIGITALLY VERIFIED ASSESSMENT</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
