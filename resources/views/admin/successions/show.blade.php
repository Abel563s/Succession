<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-8 pb-12">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.successions.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-all hover:shadow-md">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Nomination Details</h1>
                    <p class="text-slate-500 font-medium">Viewing succession nomination for {{ $succession->candidate_name }}</p>
                </div>
            </div>
            @if(auth()->user()->isAdmin())
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.successions.edit', $succession) }}" class="show-page-edit-btn">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        Edit Nomination
                    </a>
                </div>
            @endif
        </div>
        <x-hr-approval-banner :record="$succession" module="successions" />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Profile & Summary -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8 text-center">
                    <x-record-avatar :name="$succession->candidate_name" size="lg" class="mx-auto mb-6" />
                    <h2 class="text-2xl font-black text-slate-900 leading-tight mb-1">{{ $succession->candidate_name }}</h2>
                    <p class="text-slate-500 font-bold uppercase tracking-widest text-[10px] mb-6">{{ $succession->department }}</p>
                    
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-xs font-black text-slate-400 uppercase tracking-tight">Target Role:</span>
                        <span class="text-sm font-bold text-slate-700">{{ $succession->target_role }}</span>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6 space-y-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Readiness Level</label>
                        <div class="w-full py-3 rounded-2xl bg-[#D4AF37] text-white text-center font-black text-sm">
                            {{ $succession->readiness_level }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">IPG Score</label>
                        <div class="w-full py-3 rounded-2xl bg-slate-900 text-white text-center font-black text-sm">
                            {{ $succession->ipg_score }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Experience</label>
                        <div class="w-full py-3 rounded-2xl bg-white border-2 border-slate-100 text-slate-700 text-center font-black text-sm">
                            {{ $succession->years_experience }} Years
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Competencies & Assessment -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Core Information -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="text-lg font-black text-slate-900">Assessment Summary</h3>
                        <i data-lucide="clipboard-check" class="w-5 h-5 text-indigo-500"></i>
                    </div>
                    <div class="p-8 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Core Competencies</h4>
                                <p class="text-slate-600 font-medium leading-relaxed">{{ $succession->core_competencies }}</p>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Technical Competencies</h4>
                                <p class="text-slate-600 font-medium leading-relaxed">{{ $succession->technical_competencies }}</p>
                            </div>
                        </div>
                        
                        <div class="pt-8 border-t border-slate-100">
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">OKR Achievement</h4>
                            <p class="text-slate-600 font-medium leading-relaxed">{{ $succession->okr_achievement }}</p>
                        </div>

                        <div class="pt-8 border-t border-slate-100">
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Nomination Justification</h4>
                            <p class="text-slate-600 font-medium leading-relaxed italic">"{{ $succession->justification }}"</p>
                        </div>
                    </div>
                </div>

                <!-- Manager & Signature -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center">
                                <i data-lucide="user-check" class="w-6 h-6 text-slate-400"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Line Manager</p>
                                <p class="font-black text-slate-900">{{ $succession->line_manager }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            <div class="text-right hidden md:block">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Nominated On</p>
                                <p class="font-black text-slate-900">{{ $succession->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="bg-slate-50 p-2 rounded-2xl border border-slate-100">
                                @if($succession->signature_path)
                                    <img src="{{ \App\Support\StorageUrl::public($succession->signature_path) }}" class="h-16 object-contain" alt="Signature">
                                @else
                                    <div class="h-16 w-32 flex items-center justify-center border-2 border-dashed border-slate-200 rounded-xl">
                                        <span class="text-[10px] font-bold text-slate-400">No Signature</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
