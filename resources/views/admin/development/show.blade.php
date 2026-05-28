<x-app-layout>
    <div class="max-w-6xl mx-auto space-y-8 pb-12">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.development.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-all hover:shadow-md">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Development Plan Details</h1>
                    <p class="text-slate-500 font-medium">Viewing Individual Development Plan (IDP) for {{ $development->employee_name }}</p>
                </div>
            </div>
            @if(auth()->user()->isAdmin())
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.development.edit', $development) }}" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/10 flex items-center gap-2">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        Edit Plan
                    </a>
                </div>
            @endif
        </div>

        <x-hr-approval-banner :record="$development" module="development" />

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37]">
                    <i data-lucide="user" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase leading-none mb-1">Employee</p>
                    <p class="text-sm font-bold text-slate-900">{{ $development->employee_name }}</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-500">
                    <i data-lucide="building" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase leading-none mb-1">Department</p>
                    <p class="text-sm font-bold text-slate-900">{{ $development->department }}</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400">
                    <i data-lucide="user-check" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase leading-none mb-1">Line Manager</p>
                    <p class="text-sm font-bold text-slate-900">{{ $development->line_manager }}</p>
                </div>
            </div>
        </div>

        <!-- Objectives Table -->
        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h3 class="text-lg font-black text-slate-900">Development Objectives</h3>
                <span class="px-3 py-1 bg-[#D4AF37] text-white text-[10px] font-black rounded-full">{{ $development->objectives->count() }} Objectives</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/30 border-b border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-400">
                            <th class="px-6 py-4">#</th>
                            <th class="px-6 py-4">Development Objective</th>
                            <th class="px-6 py-4">Development Activity</th>
                            <th class="px-6 py-4">Support/Resource</th>
                            <th class="px-6 py-4">Timeline</th>
                            <th class="px-6 py-4">Expected Outcome</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($development->objectives as $objective)
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-400">{{ $objective->row_number }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-900">{{ $objective->objective }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-slate-600">{{ $objective->activity }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-slate-600">{{ $objective->resource }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2 text-[10px]">
                                            <span class="font-black text-slate-300 uppercase">Start:</span>
                                            <span class="font-bold text-slate-600">{{ $objective->start_date ? \Carbon\Carbon::parse($objective->start_date)->format('M d, Y') : 'N/A' }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-[10px]">
                                            <span class="font-black text-slate-300 uppercase">End:</span>
                                            <span class="font-bold text-[#D4AF37]">{{ $objective->delivery_date ? \Carbon\Carbon::parse($objective->delivery_date)->format('M d, Y') : 'N/A' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-slate-600">{{ $objective->expected_outcome }}</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($development->progressReview)
            <div class="bg-[#FFF8E7] border border-[#D4AF37]/20 rounded-2xl p-6 flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-[#111111]">Linked Progress Review</p>
                    <p class="text-sm font-medium text-slate-600 mt-1">Scores and ongoing tracking are managed in the Progress Review form.</p>
                </div>
                <a href="{{ route('admin.progress.edit', $development->progressReview) }}"
                   class="bg-[#111111] text-white px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-[#00333B] transition-all">
                    Open Progress Review
                </a>
            </div>
        @endif

        <!-- Signatures & Footer -->
        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8 flex flex-col lg:flex-row items-end justify-between gap-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 flex-1">
                <div class="space-y-3">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Manager Signature</p>
                    <x-storage-image :path="$development->signature_path" class="h-24 object-contain rounded-xl border border-slate-100 bg-slate-50 p-2" alt="Manager signature" />
                </div>
                <div class="space-y-3">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Candidate Signature</p>
                    <x-storage-image :path="$development->candidate_signature_path" class="h-24 object-contain rounded-xl border border-slate-100 bg-slate-50 p-2" alt="Candidate signature" />
                </div>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Created At</p>
                <p class="text-lg font-black text-slate-900 leading-none">{{ $development->created_at->format('M d, Y') }}</p>
                <p class="text-xs text-slate-400 font-medium mt-1">{{ $development->created_at->format('h:i A') }}</p>
            </div>
        </div>

    </div>
</x-app-layout>
