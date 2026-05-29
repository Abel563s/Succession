<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-8 pb-12">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.mentor.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-all hover:shadow-md">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Mentor Feedback Details</h1>
                    <p class="text-slate-500 font-medium">Viewing mentorship review for {{ $mentor->mentee_name }}</p>
                </div>
            </div>
            @if(auth()->user()->isAdmin())
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.mentor.edit', $mentor) }}" class="show-page-edit-btn">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        Edit Record
                    </a>
                </div>
            @endif
        </div>
        <x-hr-approval-banner :record="$mentor" module="mentor" />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Session Profile -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8 relative overflow-hidden">
                    <div class="flex flex-col items-center text-center relative">
                        <x-record-avatar :name="$mentor->mentee_name" class="mb-6" />
                        
                        <h2 class="text-xl font-black text-slate-900 mb-1 leading-tight">{{ $mentor->mentee_name }}</h2>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-6">Mentee Portfolio</p>

                        <div class="w-full space-y-3">
                            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col items-start">
                                <span class="text-[9px] font-black uppercase text-slate-400 tracking-tight mb-1">Mentor</span>
                                <span class="text-sm font-bold text-slate-700">{{ $mentor->mentor_name }}</span>
                            </div>
                            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col items-start">
                                <span class="text-[9px] font-black uppercase text-slate-400 tracking-tight mb-1">Department</span>
                                <span class="text-sm font-bold text-slate-700">{{ $mentor->department }}</span>
                            </div>
                            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col items-start">
                                <span class="text-[9px] font-black uppercase text-slate-400 tracking-tight mb-1">Period Covered</span>
                                <span class="text-sm font-bold text-slate-700">{{ $mentor->period_covered ?: 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-500 flex items-center justify-center">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Review Timeline</p>
                    </div>
                    <p class="text-sm font-bold text-slate-700 ml-11">Evaluated on {{ $mentor->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <!-- Right Column: Qualitative Feedback -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="text-lg font-black text-slate-900 tracking-tight">Performance Summary</h3>
                        <i data-lucide="line-chart" class="w-5 h-5 text-[#D4AF37]"></i>
                    </div>
                    <div class="p-8 space-y-8">
                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Key Achievements
                            </h4>
                            <div class="p-6 rounded-3xl bg-slate-50 border border-slate-100 text-slate-600 font-medium text-sm leading-relaxed whitespace-pre-wrap">
                                {{ $mentor->achievements ?: 'No achievements documented.' }}
                            </div>
                        </div>

                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Areas for Improvement
                            </h4>
                            <div class="p-6 rounded-3xl bg-slate-50 border border-slate-100 text-slate-600 font-medium text-sm leading-relaxed whitespace-pre-wrap">
                                {{ $mentor->improvement_areas ?: 'No improvement areas documented.' }}
                            </div>
                        </div>

                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                Development Recommendations
                            </h4>
                            <div class="p-6 rounded-3xl bg-indigo-50/30 border border-indigo-100 text-slate-600 font-medium text-sm leading-relaxed whitespace-pre-wrap italic">
                                "{{ $mentor->recommendations ?: 'No specific recommendations provided.' }}"
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Signature Card -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8 flex items-center justify-between overflow-hidden relative">
                    <div class="absolute right-0 bottom-0 opacity-[0.03]">
                        <i data-lucide="shield-check" class="w-40 h-40"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Mentor Authentication</p>
                        <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100 inline-block relative z-10">
                            @if($mentor->signature_path)
                                <img src="{{ \App\Support\StorageUrl::public($mentor->signature_path) }}" class="h-20 object-contain" alt="Signature">
                            @else
                                <div class="h-20 w-48 flex items-center justify-center border-2 border-dashed border-slate-200 rounded-xl">
                                    <span class="text-xs font-bold text-slate-400">No Signature Recorded</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="text-right relative z-10">
                        <p class="text-xs font-black text-slate-900 mb-1">Digitally Verified By</p>
                        <p class="text-sm font-medium text-slate-500 italic">{{ $mentor->mentor_name }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
