<x-app-layout>
    <div class="py-6 space-y-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Cutting Log History</h2>
                <p class="text-sm text-slate-500 font-medium">Detailed tracking of all bar fabrication activities</p>
            </div>
            <a href="{{ route('admin.rebar.cutting-logs.create') }}"
                class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-cyan-500/20 hover:scale-[1.02] hover:shadow-cyan-500/30 transition-all active:scale-95">
                <i data-lucide="scissors" class="w-4 h-4"></i>
                New Cutting Entry
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-200/60">
            <form method="GET" action="{{ route('admin.rebar.cutting-logs.index') }}"
                class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Filter by
                        Date</label>
                    <input type="date" name="date" value="{{ request('date') }}"
                        class="w-full bg-slate-50 border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Bar
                        Diameter</label>
                    <select name="diameter"
                        class="w-full bg-slate-50 border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600">
                        <option value="">All Sizes</option>
                        @foreach([8, 10, 12, 14, 16, 18, 20, 24, 32] as $d)
                            <option value="{{ $d }}" {{ request('diameter') == $d ? 'selected' : '' }}>{{ $d }}mm</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-1">
                    <label
                        class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ID or Element..."
                        class="w-full bg-slate-50 border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600">
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit"
                        class="flex-1 py-2.5 bg-slate-900 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all">Filter</button>
                    <a href="{{ route('admin.rebar.cutting-logs.index') }}"
                        class="p-2.5 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-all"
                        title="Reset">
                        <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Container -->
        <div
            class="bg-white rounded-[2rem] shadow-xl shadow-slate-100 border border-slate-200/60 overflow-hidden relative">
            <div class="overflow-x-auto overflow-y-visible">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Log
                                Info</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Requirement Reference</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Cutting Geometry</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Off-Cut Status</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Usage/Location</th>
                            <th
                                class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($logs as $log)
                            <tr class="hover:bg-amber-50/30 transition-all group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-slate-100 flex flex-col items-center justify-center border border-slate-200 group-hover:bg-white group-hover:border-cyan-200 transition-all">
                                            <span
                                                class="text-[9px] font-black text-slate-400 uppercase leading-none">{{ \Carbon\Carbon::parse($log->date)->format('M') }}</span>
                                            <span
                                                class="text-sm font-black text-slate-700 leading-tight">{{ \Carbon\Carbon::parse($log->date)->format('d') }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-900">
                                                #LOG-{{ str_pad($log->id, 5, '0', STR_PAD_LEFT) }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase">
                                                {{ $log->user->name ?? 'System' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @if($log->requirement)
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-black text-cyan-600 hover:text-cyan-700 transition-colors cursor-pointer">
                                                {{ $log->requirement->tracking_id }}
                                            </span>
                                            <span
                                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $log->requirement->structural_element }}</span>
                                        </div>
                                    @else
                                        <span class="text-rose-500 text-xs font-black italic">Archived</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-slate-400 uppercase">Original</span>
                                            <span
                                                class="text-sm font-bold text-slate-700">{{ $log->original_length }}mm</span>
                                        </div>
                                        <i data-lucide="arrow-right" class="w-3 h-3 text-slate-300"></i>
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-rose-400 uppercase">Used</span>
                                            <span class="text-sm font-black text-rose-500">{{ $log->cut_length }}mm</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @if($log->offcut)
                                        <div class="flex items-center gap-3">
                                            <div class="px-3 py-1 bg-emerald-50 border border-emerald-100 rounded-full">
                                                <span
                                                    class="text-[10px] font-black text-emerald-600">{{ $log->offcut->offcut_code }}</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span
                                                    class="text-[11px] font-black text-emerald-500">{{ $log->remaining_length }}mm</span>
                                                <span class="text-[8px] font-bold text-slate-300 uppercase">Remaining</span>
                                            </div>
                                        </div>
                                    @else
                                        <span
                                            class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Wastage</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-sm font-bold text-slate-600 truncate max-w-[150px]">
                                        {{ $log->used_for ?? 'N/A' }}</p>
                                    @if($log->remarks)
                                        <p class="text-[10px] text-slate-400 italic">{{ Str::limit($log->remarks, 20) }}</p>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div
                                        class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                        <form action="{{ route('admin.rebar.cutting-logs.destroy', $log) }}" method="POST"
                                            onsubmit="return confirm('Delete this log entry?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mb-4">
                                            <i data-lucide="search-x" class="w-10 h-10 text-slate-300"></i>
                                        </div>
                                        <h3 class="text-lg font-black text-slate-900">No cutting logs</h3>
                                        <p class="text-sm text-slate-500 max-w-xs mx-auto">We couldn't find any cutting
                                            records matching your search or filters.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
                <div class="px-8 py-5 border-t border-slate-50 bg-slate-50/30">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>