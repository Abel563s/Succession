<x-app-layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-4">
            <div class="flex flex-col">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Succession Planning</h1>
                <p class="text-xs text-slate-400 font-medium">Tracking candidate nominations and readiness for critical roles.</p>
            </div>

            <!-- Perfectly Centered Badge -->
            <div class="hidden lg:flex items-center justify-center">
                <div class="flex items-center gap-3 px-4 py-2 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-xl hover:border-[#111111]/20 transition-all duration-500 group/badge">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#111111] transition-colors group-hover/badge:bg-[#111111] group-hover/badge:text-white shadow-inner">
                        <i data-lucide="trending-up" class="w-5 h-5 transition-transform group-hover/badge:scale-110"></i>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-center gap-1.5">
                            <span class="text-2xl font-black text-slate-900 tracking-tighter leading-none">{{ $records->total() }}</span>
                            <div class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></div>
                        </div>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest group-hover/badge:text-slate-600 transition-colors">Total Nominations</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-end gap-3">
                <x-admin-module-help
                    name="help-successions"
                    title="Succession Planning Guide"
                    description="Assess nominee readiness and document competencies to support future succession decisions."
                    :sections="[
                        ['icon' => 'trending-up', 'title' => 'Purpose', 'content' => 'Assess the readiness of the nominee to succeed the current role holder.'],
                        ['icon' => 'list', 'title' => 'Instructions', 'content' => [
                            'Complete the nominee\'s basic information.',
                            'Assess the nominee against role requirements.',
                            'Evaluate technical competencies and non-technical competencies.',
                            'Record strengths, development areas, and readiness level.',
                        ]],
                        ['icon' => 'clipboard-check', 'title' => 'Assessment Areas', 'content' => [
                            'Technical competencies: knowledge, skills, expertise, certifications, and technical capability.',
                            'Non-technical competencies: leadership, communication, teamwork, decision-making, problem-solving, adaptability, and behavioral competencies.',
                        ]],
                    ]"
                />

                <a href="{{ route('admin.successions.create') }}" 
                   class="bg-gradient-to-r from-[#111111] to-[#00333B] hover:to-[#111111] text-white px-5 py-2.5 rounded-xl font-bold text-sm flex items-center gap-2 transition-all duration-300 shadow-lg shadow-[#111111]/20 hover:shadow-[#111111]/30 hover:scale-[1.02] active:scale-95 group/btn relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                    <i data-lucide="plus" class="w-4 h-4 relative z-10 transition-transform group-hover/btn:rotate-90"></i>
                    <span class="relative z-10">Add New Nomination</span>
                </a>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="flex justify-center">
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm inline-block">
                <form action="{{ route('admin.successions.index') }}" method="GET" class="flex flex-wrap items-end justify-center gap-4">
                    <div class="w-64 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Search</label>
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] outline-none text-xs font-bold text-slate-700"
                                   placeholder="Name, Dept...">
                        </div>
                    </div>
                    
                    <div class="w-48 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Department</label>
                        <select name="department" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] outline-none text-xs font-bold text-slate-700 appearance-none">
                            <option value="">All Depts</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}" {{ request('department') == $dept->name ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-48 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Readiness Level</label>
                        <select name="readiness_level" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] outline-none text-xs font-bold text-slate-700 appearance-none">
                            <option value="">All Levels</option>
                            <option value="Ready Now" {{ request('readiness_level') == 'Ready Now' ? 'selected' : '' }}>Ready Now</option>
                            <option value="Within 1–2 Years" {{ request('readiness_level') == 'Within 1–2 Years' ? 'selected' : '' }}>Within 1–2 Years</option>
                            <option value="Within 3–5 Years" {{ request('readiness_level') == 'Within 3–5 Years' ? 'selected' : '' }}>Within 3–5 Years</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="w-10 h-10 filter-toolbar-btn rounded-xl group/filter"
                            title="Apply Filters">
                            <i data-lucide="filter" class="w-4 h-4 transition-transform group-hover/filter:scale-110"></i>
                        </button>
                        <a href="{{ route('admin.successions.index') }}"
                            class="w-10 h-10 bg-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-rose-50 hover:text-rose-500 transition-all group/reset"
                            title="Reset Filters">
                            <i data-lucide="refresh-ccw"
                                class="w-4 h-4 transition-transform group-hover/reset:rotate-180 duration-500"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#111111] to-[#00333B] text-white text-[10px] font-black uppercase tracking-widest">
                            <th class="px-4 py-4 border-b border-white/5 text-center">#</th>
                            <th class="px-6 py-4 border-b border-white/5">Candidate & Role</th>
                            <th class="px-6 py-4 border-b border-white/5">Department</th>
                            <th class="px-6 py-4 border-b border-white/5">Manager</th>
                            <th class="px-6 py-4 border-b border-white/5">Experience</th>
                            <th class="px-6 py-4 border-b border-white/5">Readiness & IPG</th>
                            <th class="px-6 py-4 border-b border-white/5 text-center">Signature</th>
                            <th class="px-6 py-4 border-b border-white/5">Approval</th>
                            <th class="px-6 py-4 border-b border-white/5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($records as $record)
                            <tr class="hover:bg-slate-50/50 transition-colors group text-sm">
                                <td class="px-4 py-5 text-center font-bold text-slate-400 text-xs">
                                    {{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center font-black text-[#00515f]">
                                            {{ substr($record->candidate_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 leading-tight">{{ $record->candidate_name }}</p>
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Target: {{ $record->target_role }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex px-2 py-1 bg-slate-100 rounded text-[10px] font-black uppercase text-slate-500 tracking-widest">
                                        {{ $record->department }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-sm font-bold text-slate-700">{{ $record->line_manager }}</td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex px-3 py-1 rounded-lg bg-[#FFF8E7] text-[#D4AF37] text-[10px] font-black uppercase border border-[#D4AF37]/10 tracking-wider">
                                        {{ $record->years_experience }} 
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-slate-700">{{ $record->readiness_level }}</span>
                                        <span class="text-[10px] text-slate-400 font-medium">IPG Score: <span class="text-[#D4AF37] font-black">{{ $record->ipg_score }}</span></span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @if($record->signature_path)
                                        <div x-data="{ open: false }" class="relative inline-block group/sig">
                                            <img src="{{ \App\Support\StorageUrl::public($record->signature_path) }}" 
                                                 @click="open = true"
                                                 class="w-10 h-10 object-cover rounded-lg border border-slate-200 cursor-pointer"
                                                 alt="Signature">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/sig:opacity-100 transition-opacity rounded-lg flex items-center justify-center pointer-events-none">
                                                <i data-lucide="zoom-in" class="w-4 h-4 text-white"></i>
                                            </div>
                                            
                                            <div x-show="open" @click="open = false" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center modal-overlay p-4">
                                                <div class="bg-white p-2 rounded-2xl max-w-2xl" @click.stop>
                                                    <img src="{{ \App\Support\StorageUrl::public($record->signature_path) }}" class="max-w-full rounded-xl" alt="Signature Preview">
                                                    <button @click="open = false" class="mt-4 w-full py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-sm transition-colors">Close Preview</button>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-[10px] font-black uppercase text-slate-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5"><x-hr-approval-badge :status="$record->approval_status" /></td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.successions.show', $record) }}" 
                                           class="table-action-btn"
                                           title="View Details">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>

                                        @if(auth()->user()->isAdmin() || (auth()->user()->isManager() && ($record->approval_status === 'Pending' || (($record->created_by ?? $record->user_id) == auth()->id() && (!$record->approval_status || $record->approval_status === 'Pending')))))
                                            <a href="{{ route('admin.successions.edit', $record) }}" 
                                               class="table-action-btn"
                                               title="Edit Nomination">
                                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                                            </a>
                                        @endif

                                        @if(auth()->user()->isAdmin())
                                            <form action="{{ route('admin.successions.destroy', $record) }}" method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this record?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="table-action-btn table-action-btn--delete"
                                                        title="Delete Nomination">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    <p class="text-[10px] font-bold text-slate-300 mt-1 group-hover:hidden">{{ $record->created_at->format('M d, Y') }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-20 text-center text-slate-400 font-medium italic">No nomination records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($records->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
                    {{ $records->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
