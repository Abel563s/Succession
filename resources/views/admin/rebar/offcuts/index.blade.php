<x-app-layout>
    <div class="py-6 space-y-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Off-Cut Register</h2>
                <p class="text-sm text-slate-500 font-medium">Inventory of reusable rebar pieces and scrap tracking</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="px-5 py-3 bg-white border border-slate-200 rounded-2xl shadow-sm flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-xs font-black text-slate-600 uppercase tracking-widest">Live Inventory</span>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-200/60">
            <form method="GET" action="{{ route('admin.rebar.offcuts.index') }}"
                class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label
                        class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Status</label>
                    <select name="status"
                        class="w-full bg-slate-50 border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600">
                        <option value="">All Statuses</option>
                        <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available
                        </option>
                        <option value="Used" {{ request('status') == 'Used' ? 'selected' : '' }}>Used</option>
                        <option value="Scrap" {{ request('status') == 'Scrap' ? 'selected' : '' }}>Wastage</option>
                    </select>
                </div>
                <div>
                    <label
                        class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Diameter</label>
                    <select name="diameter"
                        class="w-full bg-slate-50 border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600">
                        <option value="">All Sizes</option>
                        @foreach([10, 12, 16, 20, 25, 32] as $d)
                            <option value="{{ $d }}" {{ request('diameter') == $d ? 'selected' : '' }}>{{ $d }}mm</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Site /
                        Location</label>
                    <input type="text" name="location" value="{{ request('location') }}" placeholder="Search site..."
                        class="w-full bg-slate-50 border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600">
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit"
                        class="flex-1 py-2.5 bg-slate-900 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all">Filter</button>
                    <a href="{{ route('admin.rebar.offcuts.index') }}"
                        class="p-2.5 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-all">
                        <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-100 border border-slate-200/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Off-Cut Code</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Specifications</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Status</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Site/Location</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Last
                                Updated</th>
                            <th
                                class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($offcuts as $offcut)
                            <tr class="hover:bg-slate-50/50 transition-all group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-cyan-600">
                                            <i data-lucide="hash" class="w-5 h-5"></i>
                                        </div>
                                        <span class="text-sm font-black text-slate-900">{{ $offcut->offcut_code }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-slate-400 uppercase">Diameter</span>
                                            <span
                                                class="text-sm font-bold text-slate-700">Ø{{ $offcut->bar_diameter }}mm</span>
                                        </div>
                                        <div class="w-px h-8 bg-slate-100"></div>
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-slate-400 uppercase">Length</span>
                                            <span class="text-sm font-black text-slate-900">{{ $offcut->length }}mm</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @if($offcut->status === 'Available')
                                        <div
                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 text-emerald-600 rounded-full border border-emerald-100">
                                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                            <span class="text-[10px] font-black uppercase tracking-wider">Available</span>
                                        </div>
                                    @elseif($offcut->status === 'Used')
                                        <div
                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-full border border-blue-100">
                                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div>
                                            <span class="text-[10px] font-black uppercase tracking-wider">Used</span>
                                        </div>
                                    @else
                                        <div
                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-rose-50 text-rose-600 rounded-full border border-rose-100">
                                            <div class="w-1.5 h-1.5 rounded-full bg-rose-500"></div>
                                            <span class="text-[10px] font-black uppercase tracking-wider">Wastage</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-2 text-slate-600">
                                        <i data-lucide="map-pin" class="w-4 h-4 text-slate-400"></i>
                                        <span
                                            class="text-sm font-bold">{{ $offcut->storage_location ?? 'Not Assigned' }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-bold text-slate-700">{{ $offcut->updated_at->format('M d, Y') }}</span>
                                        <span
                                            class="text-[10px] text-slate-400 font-medium">{{ $offcut->updated_at->format('h:i A') }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div
                                        class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                        <a href="{{ route('admin.rebar.offcuts.edit', $offcut) }}"
                                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-600 hover:bg-amber-500 hover:text-white transition-all shadow-sm">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.rebar.offcuts.destroy', $offcut) }}" method="POST"
                                            onsubmit="return confirm('Delete permanently?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all shadow-sm">
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
                                            <i data-lucide="package-x" class="w-10 h-10 text-slate-300"></i>
                                        </div>
                                        <h3 class="text-lg font-black text-slate-900">No off-cuts matched</h3>
                                        <p class="text-sm text-slate-500 max-w-xs mx-auto">Try adjusting your filters or
                                            check back later.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($offcuts->hasPages())
                <div class="px-8 py-5 border-t border-slate-50 bg-slate-50/30">
                    {{ $offcuts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>