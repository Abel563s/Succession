<x-app-layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-4">
            <div class="flex flex-col">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Transition Plans</h1>
                <p class="text-xs text-slate-400 font-medium">Managing role handovers, replacement plans, and transition scheduling.</p>
            </div>

            <!-- Centered Counter Badge -->
            <div class="hidden lg:flex items-center justify-center">
                <div class="flex items-center gap-3 px-4 py-2 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-xl hover:border-[#00515F]/20 transition-all duration-500 group/badge">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#00515F] transition-colors group-hover/badge:bg-[#00515F] group-hover/badge:text-white shadow-inner">
                        <i data-lucide="refresh-ccw" class="w-5 h-5 transition-transform group-hover/badge:scale-110"></i>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-center gap-1.5">
                            <span class="text-2xl font-black text-slate-900 tracking-tighter leading-none">{{ $records->total() }}</span>
                            <div class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></div>
                        </div>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest group-hover/badge:text-slate-600 transition-colors">Total Handovers</span>
                    </div>
                </div>
            </div>

            <div class="flex md:justify-end">
                <a href="{{ route('admin.transition.create') }}" 
                   class="bg-gradient-to-r from-[#00515F] to-[#00333B] hover:to-[#00515F] text-white px-5 py-2.5 rounded-xl font-bold text-sm flex items-center gap-2 transition-all duration-300 shadow-lg shadow-[#00515F]/20 hover:shadow-[#00515F]/30 hover:scale-[1.02] active:scale-95 group/btn relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                    <i data-lucide="plus" class="w-4 h-4 relative z-10 transition-transform group-hover/btn:rotate-90"></i>
                    <span class="relative z-10">Create Transition Plan</span>
                </a>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="flex justify-center">
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm inline-block">
                <form action="{{ route('admin.transition.index') }}" method="GET" class="flex flex-wrap items-end justify-center gap-4">
                    <div class="w-64 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Search</label>
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] outline-none text-xs font-bold text-slate-700"
                                   placeholder="Depts, roles, names...">
                        </div>
                    </div>

                    <div class="w-48 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Department</label>
                        <select name="department" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] outline-none text-xs font-bold text-slate-700 appearance-none">
                            <option value="">All Depts</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}" {{ request('department') == $dept->name ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-40 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Status</label>
                        <select name="status" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] outline-none text-xs font-bold text-slate-700 appearance-none">
                            <option value="">All Statuses</option>
                            <option value="Planned" {{ request('status') == 'Planned' ? 'selected' : '' }}>Planned</option>
                            <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Delayed" {{ request('status') == 'Delayed' ? 'selected' : '' }}>Delayed</option>
                        </select>
                    </div>

                    <div class="w-44 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Transition Date</label>
                        <input type="date" name="transition_date" value="{{ request('transition_date') }}" 
                               class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] outline-none text-xs font-bold text-slate-700">
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit"
                            class="w-10 h-10 bg-[#00515F] text-white rounded-xl flex items-center justify-center hover:bg-[#00333B] transition-all shadow-sm shadow-[#00515F]/20 group/filter"
                            title="Apply Filters">
                            <i data-lucide="filter" class="w-4 h-4 transition-transform group-hover/filter:scale-110"></i>
                        </button>
                        <a href="{{ route('admin.transition.index') }}"
                            class="w-10 h-10 bg-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-rose-50 hover:text-rose-500 transition-all group/reset"
                            title="Reset Filters">
                            <i data-lucide="refresh-ccw"
                                class="w-4 h-4 transition-transform group-hover/reset:rotate-180 duration-500"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table View -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#00515F] to-[#00333B] text-white text-[10px] font-black uppercase tracking-widest">
                            <th class="px-4 py-4 border-b border-white/5 text-center">#</th>
                            <th class="px-6 py-4 border-b border-white/5">Department</th>
                            <th class="px-6 py-4 border-b border-white/5">Key Handovers</th>
                            <th class="px-6 py-4 border-b border-white/5 text-center">Status</th>
                            <th class="px-6 py-4 border-b border-white/5">Created By</th>
                            <th class="px-6 py-4 border-b border-white/5">Authorized Signature</th>
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
                                    <span class="inline-flex px-2 py-1 bg-slate-100 rounded text-[10px] font-black uppercase text-slate-500 tracking-widest">
                                        {{ $record->department }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col gap-1 max-w-xs">
                                        @foreach($record->items as $item)
                                            <div class="flex items-center justify-between gap-4 text-xs font-medium text-slate-700 bg-slate-50 border border-slate-100 rounded-lg p-2">
                                                <div>
                                                    <span class="font-black text-[#00515F]">{{ $item->critical_role }}</span>
                                                    <div class="text-[10px] text-slate-400 mt-0.5">{{ $item->current_holder }} &rarr; <span class="font-bold text-[#00ADC5]">{{ $item->successor }}</span></div>
                                                </div>
                                                <span class="text-[9px] font-black uppercase tracking-wider text-slate-400 shrink-0">
                                                    {{ date('M d, Y', strtotime($item->transition_date)) }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $statusColors = [
                                            'Planned' => 'bg-blue-50 text-blue-600 border-blue-100',
                                            'In Progress' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'Completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'Delayed' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        ];
                                        $color = $statusColors[$record->status] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                                    @endphp
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $color }}">
                                        {{ $record->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-xs text-slate-600 font-bold">
                                    {{ $record->creator ? $record->creator->name : 'System Admin' }}
                                </td>
                                <td class="px-6 py-5">
                                    @if($record->signature_path)
                                        <div x-data="{ open: false }" class="relative inline-block group/sig">
                                            <img src="{{ asset('storage/' . $record->signature_path) }}" 
                                                 @click="open = true"
                                                 class="w-10 h-10 object-cover rounded-lg border border-slate-200 cursor-pointer"
                                                 alt="Signature">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/sig:opacity-100 transition-opacity rounded-lg flex items-center justify-center pointer-events-none">
                                                <i data-lucide="zoom-in" class="w-4 h-4 text-white"></i>
                                            </div>
                                            
                                            <div x-show="open" @click="open = false" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
                                                <div class="bg-white p-2 rounded-2xl max-w-2xl" @click.stop>
                                                    <img src="{{ asset('storage/' . $record->signature_path) }}" class="max-w-full rounded-xl" alt="Signature Preview">
                                                    <button @click="open = false" class="mt-4 w-full py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-sm transition-colors">Close Preview</button>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-[10px] font-black uppercase text-slate-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.transition.show', $transition = $record) }}" 
                                           class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 hover:text-[#00ADC5] hover:bg-[#f0fbfd] flex items-center justify-center transition-all"
                                           title="View Details">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>

                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('admin.transition.edit', $record) }}" 
                                               class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 hover:text-amber-500 hover:bg-amber-50 flex items-center justify-center transition-all"
                                               title="Edit Plan">
                                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                                            </a>

                                            <form action="{{ route('admin.transition.destroy', $record) }}" method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this transition plan?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 hover:text-rose-500 hover:bg-rose-50 flex items-center justify-center transition-all"
                                                        title="Delete Plan">
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
                                <td colspan="7" class="px-6 py-20 text-center text-slate-400 font-medium italic">No transition records found.</td>
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
