<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-8 pb-12">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.training.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#00515F] hover:border-[#00515F]/20 transition-all hover:shadow-md">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Training Record Details</h1>
                    <p class="text-slate-500 font-medium">Viewing program details for {{ $training->candidate_name }}</p>
                </div>
            </div>
            @if(auth()->user()->isAdmin())
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.training.edit', $training) }}" class="bg-gradient-to-r from-[#00515F] to-[#00333B] text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:to-[#00515F] transition-all shadow-lg shadow-[#00515F]/20 flex items-center gap-2">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        Edit Record
                    </a>
                </div>
            @endif
        </div>
        <x-hr-approval-banner :record="$training" module="training" />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8 text-center relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#00515F]/5 rounded-full blur-3xl"></div>
                    
                    <div class="w-24 h-24 rounded-3xl bg-[#f0fbfd] border-4 border-white shadow-xl shadow-[#00515F]/10 flex items-center justify-center font-black text-3xl text-[#00515F] mx-auto mb-6 relative z-10">
                        {{ substr($training->candidate_name, 0, 1) }}
                    </div>
                    <h2 class="text-2xl font-black text-slate-900 leading-tight mb-1 relative z-10">{{ $training->candidate_name }}</h2>
                    <p class="text-slate-500 font-bold uppercase tracking-widest text-[10px] mb-6 relative z-10">{{ $training->department }}</p>
                    
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 rounded-2xl border border-slate-100 relative z-10">
                        <span class="text-xs font-black text-slate-400 uppercase tracking-tight">Manager:</span>
                        <span class="text-sm font-bold text-slate-700">{{ $training->line_manager }}</span>
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6 space-y-4">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <p class="text-[10px] font-black text-slate-400 uppercase mb-1">Creation Date</p>
                        <p class="text-sm font-bold text-slate-900">{{ $training->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Training Goals -->
                <div class="space-y-6">
                    @for($i = 1; $i <= 3; $i++)
                        @php 
                            $goalField = "goal_$i";
                            $skillField = "skill_area_$i";
                            $scoreField = "score_$i";
                        @endphp
                        @if($training->$goalField || $training->$skillField)
                            <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden relative group">
                                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#00515F]/20 group-hover:bg-[#00515F] transition-all"></div>
                                <div class="p-8">
                                    <div class="flex items-center justify-between mb-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-[#f0fbfd] text-[#00515F] flex items-center justify-center font-black text-sm border border-[#00515F]/10">
                                                {{ $i }}
                                            </div>
                                            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest font-inter">Goal {{ $i }} Architecture</h3>
                                        </div>
                                        <div class="flex flex-col items-end">
                                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Score</span>
                                            <span class="px-4 py-1 bg-slate-900 text-white rounded-lg text-xs font-black">{{ $training->$scoreField ?: '-' }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        <div>
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Description</p>
                                            <p class="text-sm font-bold text-slate-700 leading-relaxed">{{ $training->$goalField ?: 'Not specified' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Skill / Training Area</p>
                                            <span class="inline-flex px-3 py-1 bg-[#f0fbfd] text-[#00515F] text-[10px] font-black uppercase rounded-lg border border-[#00515F]/10">
                                                {{ $training->$skillField ?: 'Not specified' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endfor
                </div>

                <!-- Execution Strategy -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="text-lg font-black text-slate-900">Execution Strategy</h3>
                        <i data-lucide="file-text" class="w-5 h-5 text-[#00515F]"></i>
                    </div>
                    <div class="p-8 space-y-8">
                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Activities</h4>
                            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 text-slate-600 font-medium whitespace-pre-wrap text-sm leading-relaxed">
                                {{ $training->activities ?: 'No activities documented.' }}
                            </div>
                        </div>

                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Expected Outcomes</h4>
                            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 text-slate-600 font-medium whitespace-pre-wrap text-sm leading-relaxed">
                                {{ $training->expected_outcomes ?: 'No outcomes documented.' }}
                            </div>
                        </div>

                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Feedback and Evaluation</h4>
                            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 text-slate-600 font-medium whitespace-pre-wrap text-sm leading-relaxed italic">
                                "{{ $training->feedback ?: 'No feedback documented yet.' }}"
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Endorsements Card -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8 overflow-hidden relative">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 relative z-10">
                        @if($training->signature_path)
                            <div class="md:col-span-2">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Verification Signature</p>
                                <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100 inline-block">
                                    <img src="{{ \App\Support\StorageUrl::public($training->signature_path) }}" class="h-20 object-contain" alt="Legacy Signature">
                                </div>
                            </div>
                        @else
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Manager Endorsement</p>
                                <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100 inline-block">
                                    @if($training->manager_signature)
                                        <img src="{{ \App\Support\StorageUrl::public($training->manager_signature) }}" class="h-20 object-contain" alt="Manager Signature">
                                    @else
                                        <div class="h-20 w-40 flex items-center justify-center border-2 border-dashed border-slate-200 rounded-xl">
                                            <span class="text-xs font-bold text-slate-400">N/A</span>
                                        </div>
                                    @endif
                                </div>
                                <p class="mt-3 text-xs font-black text-slate-900">{{ $training->line_manager }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Candidate Verification</p>
                                <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100 inline-block">
                                    @if($training->candidate_signature)
                                        <img src="{{ \App\Support\StorageUrl::public($training->candidate_signature) }}" class="h-20 object-contain" alt="Candidate Signature">
                                    @else
                                        <div class="h-20 w-40 flex items-center justify-center border-2 border-dashed border-slate-200 rounded-xl">
                                            <span class="text-xs font-bold text-slate-400">N/A</span>
                                        </div>
                                    @endif
                                </div>
                                <p class="mt-3 text-xs font-black text-slate-900">{{ $training->candidate_name }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
