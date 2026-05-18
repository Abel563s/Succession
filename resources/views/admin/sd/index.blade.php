<x-app-layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-4">
            <div class="flex flex-col">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Succession Dashboard</h1>
                <p class="text-xs text-slate-400 font-medium">Strategic overview of talent pipeline and role readiness.</p>
            </div>

            <!-- Perfectly Centered Badge -->
            <div class="hidden lg:flex items-center justify-center">
                <div class="flex items-center gap-3 px-4 py-2 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-xl hover:border-[#00515F]/20 transition-all duration-500 group/badge">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#00515F] transition-colors group-hover/badge:bg-[#00515F] group-hover/badge:text-white shadow-inner">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 transition-transform group-hover/badge:scale-110"></i>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-center gap-1.5">
                            <span class="text-2xl font-black text-slate-900 tracking-tighter leading-none">{{ $records->total() }}</span>
                            <div class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></div>
                        </div>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest group-hover/badge:text-slate-600 transition-colors">Total Dashboards</span>
                    </div>
                </div>
            </div>

            <div class="flex md:justify-end">
                <a href="{{ route('admin.sd.create') }}" 
                   class="bg-gradient-to-r from-[#00515F] to-[#00333B] hover:to-[#00515F] text-white px-5 py-2.5 rounded-xl font-bold text-sm flex items-center gap-2 transition-all duration-300 shadow-lg shadow-[#00515F]/20 hover:shadow-[#00515F]/30 hover:scale-[1.02] active:scale-95 group/btn relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                    <i data-lucide="plus" class="w-4 h-4 relative z-10 transition-transform group-hover/btn:rotate-90"></i>
                    <span class="relative z-10">New SD Entry</span>
                </a>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="flex justify-center">
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm inline-block">
                <form action="{{ route('admin.sd.index') }}" method="GET" class="flex flex-wrap items-end justify-center gap-4">
                    <div class="w-64 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Search</label>
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] outline-none text-xs font-bold text-slate-700"
                                   placeholder="Dashboard title...">
                        </div>
                    </div>
                    <div class="w-56 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Department</label>
                        <select name="department" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] outline-none text-xs font-bold text-slate-700 appearance-none">
                            <option value="">All Depts</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}" {{ request('department') == $dept->name ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                            class="w-10 h-10 bg-[#00515F] text-white rounded-xl flex items-center justify-center hover:bg-[#00333B] transition-all shadow-sm shadow-[#00515F]/20 group/filter"
                            title="Apply Filters">
                            <i data-lucide="filter" class="w-4 h-4 transition-transform group-hover/filter:scale-110"></i>
                        </button>
                        <a href="{{ route('admin.sd.index') }}"
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
                        <tr class="bg-gradient-to-r from-[#00515F] to-[#00333B] text-white text-[10px] font-black uppercase tracking-widest">
                            <th class="px-4 py-4 border-b border-white/5 text-center">#</th>
                            <th class="px-6 py-4 border-b border-white/5">Dashboard Title</th>
                            <th class="px-6 py-4 border-b border-white/5">Department</th>
                            <th class="px-6 py-4 border-b border-white/5 text-center">Status</th>
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
                                        <div class="w-10 h-10 rounded-xl bg-[#f0fbfd] border border-[#00ADC5]/10 flex items-center justify-center font-black text-[#00ADC5]">
                                            {{ substr($record->title, 0, 1) }}
                                        </div>
                                        <div class="font-bold text-slate-900 leading-tight">{{ $record->title }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex px-2 py-1 bg-slate-100 rounded text-[10px] font-black uppercase text-slate-500 tracking-widest">{{ $record->department ?: 'General' }}</span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ $record->status == 'completed' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100' }}">
                                        {{ $record->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.sd.show', $record) }}" 
                                           class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 hover:text-[#00ADC5] hover:bg-[#f0fbfd] flex items-center justify-center transition-all"
                                           title="View Dashboard">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>

                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('admin.sd.edit', $record) }}" 
                                               class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 hover:text-amber-500 hover:bg-amber-50 flex items-center justify-center transition-all"
                                               title="Edit Dashboard">
                                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                                            </a>

                                            <form action="{{ route('admin.sd.destroy', $record) }}" method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this record?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 hover:text-rose-500 hover:bg-rose-50 flex items-center justify-center transition-all"
                                                        title="Delete Dashboard">
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
                                <td colspan="4" class="px-6 py-20 text-center text-slate-400 font-medium">No succession dashboards found.</td>
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
