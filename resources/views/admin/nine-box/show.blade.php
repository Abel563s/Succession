<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-8 pb-12">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.nine-box.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-all hover:shadow-md">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Grid Evaluation Details</h1>
                    <p class="text-slate-500 font-medium">Viewing 9-box grid assessment for {{ $nineBox->candidate_name }}</p>
                </div>
            </div>
            @if(auth()->user()->isAdmin())
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.nine-box.edit', $nineBox) }}" class="show-page-edit-btn">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        Edit Evaluation
                    </a>
                </div>
            @endif
        </div>
        <x-hr-approval-banner :record="$nineBox" module="nine-box" />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Position & Scores -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Grid Position Card -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8 text-center overflow-hidden relative">
                    <div class="absolute top-0 right-0 p-4">
                        <i data-lucide="layout-grid" class="w-12 h-12 text-slate-50"></i>
                    </div>
                    
                    <x-record-avatar :name="$nineBox->candidate_name" class="mx-auto mb-6" />
                    
                    <h2 class="text-xl font-black text-slate-900 mb-1">{{ $nineBox->grid_position }}</h2>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-6">{{ $nineBox->candidate_name }}</p>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-[10px] font-black uppercase text-slate-400">Potential</span>
                            <span class="text-sm font-bold text-slate-900">{{ $nineBox->potential_level }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-[10px] font-black uppercase text-slate-400">Performance</span>
                            <span class="text-sm font-bold text-slate-900">{{ $nineBox->performance_level }}</span>
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6">
                    <h3 class="text-sm font-black text-slate-900 mb-4 uppercase tracking-tight">Organization</h3>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400">
                                <i data-lucide="building" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase leading-none mb-1">Department</p>
                                <p class="text-sm font-bold text-slate-700">{{ $nineBox->department }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase leading-none mb-1">Evaluated On</p>
                                <p class="text-sm font-bold text-slate-700">{{ $nineBox->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Qualitative Assessment -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Comments & Analysis -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="text-lg font-black text-slate-900">Qualitative Assessment</h3>
                        <i data-lucide="file-text" class="w-5 h-5 text-[#D4AF37]"></i>
                    </div>
                    <div class="p-8 space-y-8">
                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                Key Strengths
                            </h4>
                            <p class="text-slate-600 font-medium leading-relaxed">{{ $nineBox->strengths }}</p>
                        </div>

                        <div class="pt-8 border-t border-slate-100">
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
                                Development Needs
                            </h4>
                            <p class="text-slate-600 font-medium leading-relaxed">{{ $nineBox->development_needs }}</p>
                        </div>

                        <div class="pt-8 border-t border-slate-100">
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">General Comments</h4>
                            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 italic text-slate-600 font-medium">
                                "{{ $nineBox->general_comments }}"
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Signature -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-8 flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Official Authentication</p>
                            <div class="bg-slate-50 p-2 rounded-2xl border border-slate-100 inline-block">
                                @if($nineBox->signature_path)
                                    <img src="{{ \App\Support\StorageUrl::public($nineBox->signature_path) }}" class="h-20 object-contain" alt="Signature">
                                @else
                                    <div class="h-20 w-40 flex items-center justify-center border-2 border-dashed border-slate-200 rounded-xl">
                                        <span class="text-xs font-bold text-slate-400">No Signature</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-black text-slate-900 mb-1">Digitally Signed By</p>
                            <p class="text-sm font-medium text-slate-500 italic">{{ $nineBox->candidate_name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
