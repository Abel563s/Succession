<x-app-layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-4 pb-4 border-b border-slate-100">
            <div class="flex flex-col text-left">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Coaching Sessions</h1>
                <p class="text-xs text-slate-400 font-medium">Monitoring professional coaching engagements and developmental action plans.</p>
            </div>

            <!-- Centered Counter Badge -->
            <div class="hidden lg:flex items-center justify-center">
                <div class="flex items-center gap-3 px-4 py-2 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-xl hover:border-[#111111]/20 transition-all duration-500 group/badge">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#111111] transition-colors group-hover/badge:bg-[#111111] group-hover/badge:text-white shadow-inner">
                        <i data-lucide="award" class="w-5 h-5 transition-transform group-hover/badge:scale-110"></i>
                    </div>
                    <div class="flex flex-col text-left">
                        <div class="flex items-center gap-1.5">
                            <span class="text-2xl font-black text-slate-900 tracking-tighter leading-none">{{ $records->total() }}</span>
                            <div class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></div>
                        </div>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest group-hover/badge:text-slate-600 transition-colors">Total Sessions</span>
                    </div>
                </div>
            </div>

            <div class="flex md:justify-end">
                <a href="{{ route('admin.coaching.create') }}" 
                   class="bg-gradient-to-r from-[#111111] to-[#00333B] hover:to-[#111111] text-white px-5 py-2.5 rounded-xl font-bold text-sm flex items-center gap-2 transition-all duration-300 shadow-lg shadow-[#111111]/20 hover:shadow-[#111111]/30 hover:scale-[1.02] active:scale-95 group/btn relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                    <i data-lucide="plus" class="w-4 h-4 relative z-10 transition-transform group-hover/btn:rotate-90"></i>
                    <span class="relative z-10">Add Coaching Session</span>
                </a>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="flex justify-center">
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm inline-block">
                <form action="{{ route('admin.coaching.index') }}" method="GET" class="flex flex-wrap items-end justify-center gap-4">
                    <div class="w-64 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Search</label>
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] outline-none text-xs font-bold text-slate-700"
                                   placeholder="Coach, candidate, topic...">
                        </div>
                    </div>

                    <div class="w-48 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Department</label>
                        <select name="department" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] outline-none text-xs font-bold text-slate-700 appearance-none cursor-pointer">
                            <option value="">All Departments</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}" {{ request('department') == $dept->name ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-44 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Coaching Date</label>
                        <input type="date" name="coaching_date" value="{{ request('coaching_date') }}" 
                               class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] outline-none text-xs font-bold text-slate-700">
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit"
                            class="w-10 h-10 bg-[#111111] text-white rounded-xl flex items-center justify-center hover:bg-[#00333B] transition-all shadow-sm shadow-[#111111]/20 group/filter"
                            title="Apply Filters">
                            <i data-lucide="filter" class="w-4 h-4 transition-transform group-hover/filter:scale-110"></i>
                        </button>
                        <a href="{{ route('admin.coaching.index') }}"
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
                            <th class="px-6 py-4 border-b border-white/5">Candidate & Coach</th>
                            <th class="px-6 py-4 border-b border-white/5">Department</th>
                            <th class="px-6 py-4 border-b border-white/5 text-center">Date</th>
                            <th class="px-6 py-4 border-b border-white/5">Primary Topic</th>
                            <th class="px-6 py-4 border-b border-white/5">Timeline / Plan</th>
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
                                    <div class="flex items-center gap-3 text-left">
                                        <div class="relative shrink-0">
                                            <div class="w-10 h-10 rounded-xl bg-[#FFF8E7] border border-[#D4AF37]/10 flex items-center justify-center font-black text-[#D4AF37] text-sm shadow-inner transition-transform group-hover:scale-110 duration-500">
                                                {{ substr($record->candidate_name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 leading-tight">{{ $record->candidate_name }}</p>
                                            <p class="text-xs text-slate-500 font-medium mt-0.5">Coach: <span class="font-bold text-[#D4AF37]">{{ $record->supervisor }}</span></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex px-2 py-1 rounded-lg bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-tight">
                                        {{ $record->department }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="text-xs font-bold text-slate-600">
                                        {{ $record->coaching_date ? date('M d, Y', strtotime($record->coaching_date)) : 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-xs font-medium text-slate-500 line-clamp-1 max-w-xs">{{ $record->topic_1 }}</p>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-xs font-semibold text-slate-600">
                                        {{ $record->timeline ?: 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-5"><x-hr-approval-badge :status="$record->approval_status" /></td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.coaching.show', $record) }}" 
                                           class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 hover:text-[#D4AF37] hover:bg-[#FFF8E7] flex items-center justify-center transition-all"
                                           title="View Details">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>

                                        @if(auth()->user()->isAdmin() || (auth()->user()->isManager() && ($record->approval_status === 'Pending' || (($record->created_by ?? $record->user_id) == auth()->id() && (!$record->approval_status || $record->approval_status === 'Pending')))))
                                            <a href="{{ route('admin.coaching.edit', $record) }}" 
                                               class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 hover:text-amber-500 hover:bg-amber-50 flex items-center justify-center transition-all"
                                               title="Edit Record">
                                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                                            </a>
                                        @endif

                                        @if(auth()->user()->isAdmin())
                                            <form action="{{ route('admin.coaching.destroy', $record) }}" method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this record?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 hover:text-rose-500 hover:bg-rose-50 flex items-center justify-center transition-all"
                                                        title="Delete Record">
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
                                <td colspan="8" class="px-6 py-20 text-center text-slate-400 font-medium italic">No coaching sessions recorded.</td>
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
