<x-app-layout>
    <div class="py-6 space-y-8 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Rebar Requirements</h2>
                <nav
                    class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mt-1">
                    <span>Registry</span>
                    <li class="list-none p-1 rounded-full bg-slate-100"><i data-lucide="chevron-right"
                            class="w-2.5 h-2.5"></i></li>
                    <li class="list-none text-[#D4AF37]">Structural elements</li>
                </nav>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden lg:flex flex-col items-end mr-4">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Global Volume</span>
                    <span
                        class="text-xl font-black text-slate-900 tracking-tighter">{{ number_format($totalLength, 1) }}m</span>
                </div>
                <a href="{{ route('admin.rebar.requirements.create') }}"
                    class="flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-[#D4AF37] to-[#B8860B] text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-cyan-500/20 hover:scale-[1.02] transition-all active:scale-95">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    New Requirement
                </a>
            </div>
        </div>

        <!-- Filter Modern Bar -->
        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-200/60 transition-all hover:shadow-md">
            <form method="GET" action="{{ route('admin.rebar.requirements.index') }}"
                class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Search
                        Keywords</label>
                    <div class="relative">
                        <i data-lucide="search"
                            class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="ID, Location, Drawing..."
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border-transparent rounded-xl font-bold text-sm text-slate-700 focus:ring-4 focus:ring-cyan-500/10 focus:bg-white transition-all">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Bar
                        Diameter</label>
                    <select name="diameter"
                        class="w-full py-3 bg-slate-50 border-transparent rounded-xl font-bold text-sm text-slate-700 focus:ring-4 focus:ring-cyan-500/10 focus:bg-white transition-all">
                        <option value="">All Sizes</option>
                        @foreach([10, 12, 16, 20, 25, 32] as $d)
                            <option value="{{ $d }}" {{ request('diameter') == $d ? 'selected' : '' }}>Ø{{ $d }}mm</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label
                        class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Structural
                        element</label>
                    <input type="text" name="element" value="{{ request('element') }}" placeholder="e.g. Columns, Beam"
                        class="w-full py-3 bg-slate-50 border-transparent rounded-xl font-bold text-sm text-slate-700 focus:ring-4 focus:ring-cyan-500/10 focus:bg-white transition-all">
                </div>
                <div class="hidden lg:block"></div>
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="flex-1 py-3 bg-slate-900 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg shadow-slate-200">
                        Apply Filter
                    </button>
                    <a href="{{ route('admin.rebar.requirements.index') }}"
                        class="p-3 bg-slate-100 text-slate-400 rounded-xl hover:bg-slate-200 transition-all"
                        title="Reset">
                        <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Interactive Table -->
        <div
            class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-slate-200/60 overflow-hidden relative">
            <div class="overflow-x-auto overflow-y-visible">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Requirement Reference</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Structural Element</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Technical Specs</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Quantity</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Drawing Info</th>
                            <th
                                class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($requirements as $req)
                            <tr class="hover:bg-amber-50/30 transition-all group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 font-black text-[10px] border border-slate-200 group-hover:bg-amber-500 group-hover:text-white group-hover:border-cyan-400 transition-all">
                                            ID
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-900 tracking-tight">
                                                {{ $req->tracking_id }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase">
                                                {{ $req->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="px-3 py-1 bg-slate-100 rounded-full border border-slate-200 inline-block">
                                        <p class="text-[10px] font-black text-slate-600 uppercase">
                                            {{ $req->structural_element }}</p>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                            <span
                                                class="text-sm font-black text-slate-700 tracking-tight">Ø{{ $req->bar_diameter }}mm</span>
                                        </div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase ml-4">L:
                                            {{ $req->required_length }}mm | T: {{ number_format($req->total_length, 1) }}m
                                        </p>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span
                                        class="text-lg font-black text-slate-900 tracking-tighter">{{ $req->quantity }}</span>
                                    <span class="text-[10px] font-black text-slate-400 uppercase ml-1">PCS</span>
                                </td>
                                <td class="px-8 py-5">
                                    @if($req->drawing_reference)
                                        <div class="flex items-center gap-2 text-slate-600">
                                            <i data-lucide="blueprint" class="w-3 h-3"></i>
                                            <span
                                                class="text-[10px] font-bold uppercase tracking-wider">{{ $req->drawing_reference }}</span>
                                        </div>
                                    @else
                                        <span class="text-[10px] font-bold text-slate-300 uppercase italic">N/A</span>
                                    @endif
                                </td>
                                <td class="px-8 py-5">
                                    <div
                                        class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0">
                                        <a href="{{ route('admin.rebar.cutting-logs.create', ['requirement_id' => $req->id]) }}"
                                            class="p-2.5 text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all"
                                            title="Record Cut">
                                            <i data-lucide="scissors" class="w-4 h-4"></i>
                                        </a>
                                        <a href="{{ route('admin.rebar.requirements.edit', $req) }}"
                                            class="p-2.5 text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all"
                                            title="Edit">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.rebar.requirements.destroy', $req) }}" method="POST"
                                            onsubmit="return confirm('Archive this requirement?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2.5 text-rose-600 hover:bg-rose-50 rounded-xl transition-all"
                                                title="Remove">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <div
                                            class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200">
                                            <i data-lucide="file-warning" class="w-10 h-10"></i>
                                        </div>
                                        <div>
                                            <p class="text-slate-900 font-black tracking-tight">Registry is Empty</p>
                                            <p class="text-xs font-medium text-slate-400">No structural requirements match
                                                your current filters.</p>
                                        </div>
                                        <a href="{{ route('admin.rebar.requirements.index') }}"
                                            class="px-6 py-2 bg-slate-900 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-800 transition-all">Clear
                                            Filters</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($requirements->hasPages())
                <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/30">
                    {{ $requirements->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>