<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-8 pb-12">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.coaching.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-all hover:shadow-md">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Coaching Session Details</h1>
                    <p class="text-slate-500 font-medium">Viewing professional coaching record for {{ $coaching->candidate_name }}</p>
                </div>
            </div>
            @if(auth()->user()->isAdmin())
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.coaching.edit', $coaching) }}" class="show-page-edit-btn">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        Edit Record
                    </a>
                </div>
            @endif
        </div>

        <x-hr-approval-banner :record="$coaching" module="coaching" />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Session Profile -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#111111]/5 rounded-full blur-3xl"></div>
                    
                    <div class="flex flex-col items-center text-center relative">
                        <x-record-avatar :name="$coaching->candidate_name" class="mb-6" />
                        
                        <h2 class="text-xl font-black text-slate-900 mb-1 leading-tight">{{ $coaching->candidate_name }}</h2>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-6">Employee Profile</p>

                        <div class="w-full space-y-3">
                            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col items-start">
                                <span class="text-[9px] font-black uppercase text-slate-400 tracking-tight mb-1">Supervisor / Coach</span>
                                <span class="text-sm font-bold text-slate-700">{{ $coaching->supervisor }}</span>
                            </div>
                            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col items-start">
                                <span class="text-[9px] font-black uppercase text-slate-400 tracking-tight mb-1">Department</span>
                                <span class="text-sm font-bold text-slate-700">{{ $coaching->department }}</span>
                            </div>
                            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col items-start">
                                <span class="text-[9px] font-black uppercase text-slate-400 tracking-tight mb-1">Coaching Date</span>
                                <span class="text-sm font-bold text-slate-700">{{ \Carbon\Carbon::parse($coaching->coaching_date)->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4 flex items-center gap-2">
                        <i data-lucide="target" class="w-4 h-4 text-[#111111]"></i>
                        Core Focus Topics
                    </h4>
                    <div class="space-y-3">
                        @foreach(['topic_1', 'topic_2', 'topic_3'] as $topic)
                            @if($coaching->$topic)
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-xs font-bold text-slate-700 leading-relaxed">
                                    {{ $coaching->$topic }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Strategic Roadmap -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="text-lg font-black text-slate-900 tracking-tight">Strategic Roadmap</h3>
                        <i data-lucide="map" class="w-5 h-5 text-[#111111]"></i>
                    </div>
                    <div class="p-8 space-y-8">
                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#111111]"></span>
                                Desired Outcome
                            </h4>
                            <div class="p-6 rounded-3xl bg-slate-50 border border-slate-100 text-slate-600 font-medium text-sm leading-relaxed whitespace-pre-wrap">
                                {{ $coaching->desired_outcome ?: 'No specific outcome documented.' }}
                            </div>
                        </div>

                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Benefits of Change
                            </h4>
                            <div class="p-6 rounded-3xl bg-slate-50 border border-slate-100 text-slate-600 font-medium text-sm leading-relaxed whitespace-pre-wrap">
                                {{ $coaching->benefits ?: 'No benefits documented.' }}
                            </div>
                        </div>

                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Action Plan
                            </h4>
                            <div class="p-6 rounded-3xl bg-slate-50 border border-slate-100 text-slate-600 font-medium text-sm leading-relaxed whitespace-pre-wrap">
                                {{ $coaching->action_plan ?: 'No action plan documented.' }}
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4 border-t border-slate-100">
                            <div>
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Supervisor Support</h4>
                                <p class="text-sm font-bold text-slate-700 leading-relaxed">{{ $coaching->supervisor_support ?: 'None specified' }}</p>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Timeline</h4>
                                <span class="inline-flex px-3 py-1 bg-slate-900 text-white text-[10px] font-black uppercase rounded-lg">
                                    {{ $coaching->timeline ?: 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Endorsements Card -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8 overflow-hidden relative">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 relative z-10">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Manager Endorsement</p>
                            <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100 inline-block">
                                @if($coaching->manager_signature)
                                    <img src="{{ \App\Support\StorageUrl::public($coaching->manager_signature) }}" class="h-20 object-contain" alt="Manager Signature">
                                @else
                                    <div class="h-20 w-40 flex items-center justify-center border-2 border-dashed border-slate-200 rounded-xl">
                                        <span class="text-xs font-bold text-slate-400">N/A</span>
                                    </div>
                                @endif
                            </div>
                            <p class="mt-3 text-xs font-black text-slate-900">{{ $coaching->supervisor }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Candidate Verification</p>
                            <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100 inline-block">
                                @if($coaching->candidate_signature)
                                    <img src="{{ \App\Support\StorageUrl::public($coaching->candidate_signature) }}" class="h-20 object-contain" alt="Candidate Signature">
                                @else
                                    <div class="h-20 w-40 flex items-center justify-center border-2 border-dashed border-slate-200 rounded-xl">
                                        <span class="text-xs font-bold text-slate-400">N/A</span>
                                    </div>
                                @endif
                            </div>
                            <p class="mt-3 text-xs font-black text-slate-900">{{ $coaching->candidate_name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
