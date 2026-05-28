<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-8 pb-12">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.critical-roles.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-all hover:shadow-md">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Role Evaluation Details</h1>
                    <p class="text-slate-500 font-medium">Viewing details for {{ $criticalRole->employee_name }}</p>
                </div>
            </div>
            @if(auth()->user()->isAdmin())
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.critical-roles.edit', $criticalRole) }}" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/10 flex items-center gap-2">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        Edit Record
                    </a>
                </div>
            @endif
        </div>

        <x-hr-approval-banner :record="$criticalRole" module="critical-roles" />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Employee Info & Status -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Profile Card -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8 text-center">
                    <div class="w-24 h-24 rounded-3xl bg-[#FFF8E7] border-4 border-white shadow-xl shadow-[#D4AF37]/10 flex items-center justify-center font-black text-3xl text-[#D4AF37] mx-auto mb-6">
                        {{ substr($criticalRole->employee_name, 0, 1) }}
                    </div>
                    <h2 class="text-2xl font-black text-slate-900 leading-tight mb-1">{{ $criticalRole->employee_name }}</h2>
                    <p class="text-slate-500 font-bold uppercase tracking-widest text-[10px] mb-6">{{ $criticalRole->department }}</p>
                    
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-xs font-black text-slate-400 uppercase tracking-tight">Role:</span>
                        <span class="text-sm font-bold text-slate-700">{{ $criticalRole->critical_role }}</span>
                    </div>
                </div>

                <!-- Status Pills -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6 space-y-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Vacancy Risk</label>
                        @php
                            $riskColor = match($criticalRole->vacancy_risk) {
                                'High' => 'bg-rose-500 text-white',
                                'Moderate' => 'bg-amber-500 text-white',
                                'Low' => 'bg-emerald-500 text-white',
                                default => 'bg-slate-400 text-white'
                            };
                        @endphp
                        <div class="w-full py-3 rounded-2xl {{ $riskColor }} text-center font-black text-sm shadow-lg shadow-current/10">
                            {{ $criticalRole->vacancy_risk }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Position Impact</label>
                        <div class="w-full py-3 rounded-2xl bg-slate-900 text-white text-center font-black text-sm">
                            {{ $criticalRole->position_impact }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Position Status</label>
                        <div class="w-full py-3 rounded-2xl bg-white border-2 border-slate-100 text-slate-700 text-center font-black text-sm">
                            {{ $criticalRole->position_status }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Successors & Mitigation -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Successors Section -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <h3 class="text-lg font-black text-slate-900">Succession Pipeline</h3>
                        <i data-lucide="users" class="w-5 h-5 text-slate-400"></i>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Successor 1 -->
                        <div class="space-y-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-xl bg-[#D4AF37]/10 text-[#D4AF37] flex items-center justify-center font-black text-xs">1</div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Primary</span>
                            </div>
                            @if($criticalRole->successor_1_name)
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                    <p class="font-bold text-slate-900 mb-1">{{ $criticalRole->successor_1_name }}</p>
                                    <span class="inline-flex px-2 py-0.5 rounded-md bg-white border border-slate-200 text-[10px] font-bold text-[#D4AF37]">
                                        {{ $criticalRole->successor_1_readiness }}
                                    </span>
                                </div>
                            @else
                                <div class="p-4 rounded-2xl border border-dashed border-slate-200 flex flex-col items-center justify-center py-8">
                                    <p class="text-xs font-bold text-slate-400">Not Assigned</p>
                                </div>
                            @endif
                        </div>

                        <!-- Successor 2 -->
                        <div class="space-y-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center font-black text-xs">2</div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Secondary</span>
                            </div>
                            @if($criticalRole->successor_2_name)
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                    <p class="font-bold text-slate-900 mb-1">{{ $criticalRole->successor_2_name }}</p>
                                    <span class="inline-flex px-2 py-0.5 rounded-md bg-white border border-slate-200 text-[10px] font-bold text-slate-500">
                                        {{ $criticalRole->successor_2_readiness }}
                                    </span>
                                </div>
                            @else
                                <div class="p-4 rounded-2xl border border-dashed border-slate-200 flex flex-col items-center justify-center py-8">
                                    <p class="text-xs font-bold text-slate-400">Not Assigned</p>
                                </div>
                            @endif
                        </div>

                        <!-- Successor 3 -->
                        <div class="space-y-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center font-black text-xs">3</div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Tertiary</span>
                            </div>
                            @if($criticalRole->successor_3_name)
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                    <p class="font-bold text-slate-900 mb-1">{{ $criticalRole->successor_3_name }}</p>
                                    <span class="inline-flex px-2 py-0.5 rounded-md bg-white border border-slate-200 text-[10px] font-bold text-slate-500">
                                        {{ $criticalRole->successor_3_readiness }}
                                    </span>
                                </div>
                            @else
                                <div class="p-4 rounded-2xl border border-dashed border-slate-200 flex flex-col items-center justify-center py-8">
                                    <p class="text-xs font-bold text-slate-400">Not Assigned</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Mitigation Plan -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <h3 class="text-lg font-black text-slate-900">Mitigation & Retention Plan</h3>
                        <i data-lucide="shield-check" class="w-5 h-5 text-[#D4AF37]"></i>
                    </div>
                    <div class="p-8">
                        <div class="prose prose-slate max-w-none">
                            <p class="text-slate-600 leading-relaxed font-medium">
                                {{ $criticalRole->mitigation_plan }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Signature Section -->
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-lg font-black text-slate-900">Authorization</h3>
                    </div>
                    <div class="p-8 flex items-end justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Digitally Signed By</p>
                            <div class="flex items-center gap-4">
                                <div class="bg-slate-50 p-2 rounded-2xl border border-slate-100">
                                    @if($criticalRole->signature_path)
                                        <img src="{{ \App\Support\StorageUrl::public($criticalRole->signature_path) }}" class="h-20 object-contain" alt="Signature">
                                    @else
                                        <div class="h-20 w-40 flex items-center justify-center border-2 border-dashed border-slate-200 rounded-xl">
                                            <span class="text-xs font-bold text-slate-400">No Signature</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-black text-slate-900">{{ $criticalRole->employee_name }}</p>
                                    <p class="text-xs text-slate-400 font-bold uppercase tracking-tight italic">Authenticated Digital Signature</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Evaluation Date</p>
                            <p class="font-black text-slate-900">{{ $criticalRole->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
