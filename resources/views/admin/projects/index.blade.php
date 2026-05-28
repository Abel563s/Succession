<x-app-layout>
    <div class="py-10 px-6 space-y-8 max-w-[1700px] mx-auto font-inter animate-fade-in">

        <!-- Modern Compact Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 pb-4 border-b border-slate-100">
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center text-white shadow-xl shadow-slate-900/20">
                        <i data-lucide="layers" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-light text-slate-400 tracking-tight font-outfit leading-none">
                            Project <span class="font-black text-slate-900">Registry</span>
                        </h2>
                        <p class="text-[10px] font-black text-[#D4AF37] uppercase tracking-[0.3em] mt-2">Operational
                            Matrix Archive</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- Aggregate Registry Counter -->
                <div class="flex items-center gap-3 px-6 py-3 bg-white border border-slate-100 rounded-2xl shadow-sm">
                    <div class="w-2 h-2 rounded-full bg-[#D4AF37] animate-pulse"></div>
                    <div class="flex flex-col">
                        <span
                            class="text-[10px] font-black text-slate-900 tracking-widest uppercase leading-tight">{{ $projects->count() }}
                            Projects</span>
                        <span
                            class="text-[8px] font-bold text-slate-400 uppercase tracking-[0.2em] leading-tight">Registered</span>
                    </div>
                </div>

                <a href="{{ route('admin.projects.create') }}"
                    class="group/btn relative px-8 py-4 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest overflow-hidden transition-all hover:scale-105 active:scale-95 shadow-xl shadow-slate-900/20">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-[#D4AF37] to-blue-500 translate-x-[-100%] group-hover/btn:translate-x-0 transition-transform duration-500">
                    </div>
                    <span class="relative flex items-center gap-2">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        New Project
                    </span>
                </a>
            </div>
        </div>



        <!-- Search & Advanced Filter Area -->
        <form action="{{ route('admin.projects.index') }}" method="GET" class="space-y-6">
            <div
                class="backdrop-blur-xl bg-white/80 p-6 rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white flex flex-wrap items-center gap-6">
                <div class="flex-1 relative min-w-[350px] group">
                    <i data-lucide="search"
                        class="absolute left-6 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300 group-focus-within:text-[#D4AF37] transition-colors"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search operational registry by name, code or protocol..."
                        class="w-full pl-16 pr-8 py-5 bg-slate-50 border-2 border-transparent rounded-[1.5rem] text-sm font-bold text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-4 focus:ring-cyan-100/50 focus:bg-white focus:border-[#D4AF37]/20 transition-all">
                </div>

                <div class="flex items-center gap-4">
                    <!-- Project Module Filter -->
                    <div class="relative group/select">
                        <select name="type" onchange="this.form.submit()"
                            class="appearance-none pl-8 pr-12 py-5 bg-slate-50 border-2 border-transparent rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest text-slate-500 cursor-pointer hover:bg-slate-100 transition-all focus:ring-4 focus:ring-slate-100 focus:bg-white min-w-[180px]">
                            <option value="">All Modules</option>
                            @foreach(['Building', 'Fit-Out', 'Infrastructure', 'Mixed (Bui/Road)', 'Mixed (Bui/Fit-Out)'] as $type)
                                <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}
                                </option>
                            @endforeach
                        </select>
                        <i data-lucide="chevron-down"
                            class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none transition-transform group-hover/select:translate-y-[-40%]"></i>
                    </div>

                    <!-- Delivery Method Filter -->
                    <div class="relative group/select">
                        <select name="delivery_method" onchange="this.form.submit()"
                            class="appearance-none pl-8 pr-12 py-5 bg-slate-50 border-2 border-transparent rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest text-slate-500 cursor-pointer hover:bg-slate-100 transition-all focus:ring-4 focus:ring-slate-100 focus:bg-white min-w-[180px]">
                            <option value="">All Methods</option>
                            @foreach(['DBB', 'DB', 'CM', 'Negotiated'] as $method)
                                <option value="{{ $method }}" {{ request('delivery_method') == $method ? 'selected' : '' }}>
                                    {{ $method }}
                                </option>
                            @endforeach
                        </select>
                        <i data-lucide="chevron-down"
                            class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none transition-transform group-hover/select:translate-y-[-40%]"></i>
                    </div>

                    @if(request()->anyFilled(['search', 'type', 'delivery_method']))
                        <a href="{{ route('admin.projects.index') }}"
                            class="flex items-center justify-center w-14 h-14 bg-rose-50 text-rose-500 rounded-[1.2rem] hover:bg-rose-500 hover:text-white transition-all active:scale-90 shadow-sm"
                            title="Clear Filters">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <!-- Registry Data Table -->
        <div
            class="bg-white rounded-[3.5rem] shadow-2xl shadow-slate-200/40 border border-slate-50 overflow-hidden relative">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/80 backdrop-blur-md">
                            <th
                                class="px-12 py-10 text-[10px] font-black text-slate-500 uppercase tracking-[0.25em] border-b border-slate-100">
                                Project Identity</th>
                            <th
                                class="px-8 py-10 text-[10px] font-black text-slate-500 uppercase tracking-[0.25em] border-b border-slate-100">
                                Classification</th>
                            <th
                                class="px-8 py-10 text-[10px] font-black text-slate-500 uppercase tracking-[0.25em] border-b border-slate-100">
                                Stakeholder Hub</th>
                            <th
                                class="px-8 py-10 text-[10px] font-black text-slate-500 uppercase tracking-[0.25em] border-b border-slate-100 text-right">
                                Contract Budget</th>
                            <th
                                class="px-8 py-10 text-[10px] font-black text-slate-500 uppercase tracking-[0.25em] border-b border-slate-100 text-center">
                                Lifecycle Status</th>
                            <th class="px-12 py-10 text-right border-b border-slate-100"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50/50">
                        @forelse($projects as $project)
                            <tr class="group cursor-pointer hover:bg-slate-50/80 transition-all duration-500 odd:bg-white even:bg-slate-50/20"
                                onclick="window.location='{{ route('admin.projects.show', $project->id) }}'">
                                <td class="px-12 py-9">
                                    <div class="flex items-center gap-6">
                                        <div class="relative">
                                            <div
                                                class="w-16 h-16 rounded-[1.5rem] bg-white shadow-lg border border-slate-100 flex items-center justify-center transition-all duration-500 group-hover:rotate-[10deg] group-hover:scale-110 group-hover:border-[#D4AF37]">
                                                <span
                                                    class="font-black text-[10px] text-slate-300 group-hover:text-[#D4AF37] tracking-tighter">{{ $project->project_code }}</span>
                                            </div>
                                            <div
                                                class="absolute -bottom-2 -right-2 w-6 h-6 rounded-lg bg-emerald-500 border-2 border-white flex items-center justify-center shadow-md">
                                                <i data-lucide="check" class="w-3 h-3 text-white"></i>
                                            </div>
                                        </div>
                                        <div class="space-y-1.5">
                                            <p
                                                class="text-base font-black text-slate-900 leading-tight group-hover:text-[#D4AF37] transition-colors">
                                                {{ $project->project_name }}
                                            </p>
                                            <div class="flex items-center gap-3">
                                                <span
                                                    class="text-[9px] font-black text-slate-500 uppercase tracking-widest bg-slate-100 px-2 py-0.5 rounded-md">{{ $project->custom_id }}</span>
                                                <span class="w-1 h-1 rounded-full bg-slate-300 text-xs"></span>
                                                <span
                                                    class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ $project->revision_number ?? 'v1.0' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-9">
                                    <div class="space-y-2">
                                        <p
                                            class="text-[10px] font-black text-slate-800 uppercase tracking-wider flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37]"></span>
                                            {{ $project->project_type }}
                                        </p>
                                        <div class="inline-flex px-3 py-1 bg-slate-100 rounded-lg">
                                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">
                                                {{ $project->delivery_method }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-9">
                                    <div class="space-y-1.5">
                                        <p class="text-xs font-black text-slate-900">{{ $project->project_client }}</p>
                                        <div
                                            class="flex items-center gap-2 text-slate-400 group-hover:text-amber-600 transition-colors">
                                            <i data-lucide="briefcase" class="w-3 h-3"></i>
                                            <p class="text-[9px] font-black uppercase tracking-widest">
                                                {{ $project->consultant }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-9 text-right">
                                    <div class="space-y-1.5">
                                        <p
                                            class="text-sm font-mono font-black text-slate-900 group-hover:scale-105 transition-transform origin-right">
                                            ETB {{ number_format($project->contract_budget) }}</p>
                                        <div
                                            class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 rounded-lg border border-emerald-100/50">
                                            <span class="w-1 h-1 rounded-full bg-emerald-500"></span>
                                            <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest">
                                                Allowable: {{ number_format($project->total_allowable_cost) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-9 text-center">
                                    @php
                                        $colors = [
                                            'Not Completed' => 'bg-amber-100/50 text-amber-600 border-amber-200/50',
                                            'PPA Received' => 'bg-cyan-100/50 text-[#D4AF37] border-cyan-200/50',
                                            'PA Received' => 'bg-indigo-100/50 text-indigo-600 border-indigo-200/50',
                                            'FA Received' => 'bg-emerald-100/50 text-emerald-600 border-emerald-200/50',
                                            'Snag / Di-Snag' => 'bg-rose-100/50 text-rose-600 border-rose-200/50',
                                            'Waiting for PA' => 'bg-slate-100/50 text-slate-600 border-slate-200/50',
                                        ];
                                        $color = $colors[$project->closing_status] ?? 'bg-slate-100 text-slate-400 border-slate-200';
                                    @endphp
                                    <span
                                        class="inline-flex px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-[0.15em] {{ $color }} border-2 shadow-sm group-hover:shadow-md transition-all">
                                        {{ $project->closing_status }}
                                    </span>
                                </td>
                                <td class="px-12 py-9 text-right">
                                    <div
                                        class="flex items-center justify-end gap-2 translate-x-4 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-500">
                                        <button
                                            class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-[#D4AF37] hover:text-white hover:border-[#D4AF37] transition-all duration-300">
                                            <i data-lucide="external-link" class="w-4 h-4"></i>
                                        </button>
                                        <button
                                            class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all duration-300">
                                            <i data-lucide="more-vertical" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-12 py-32 text-center">
                                    <div class="flex flex-col items-center gap-6">
                                        <div class="relative">
                                            <div
                                                class="w-24 h-24 rounded-[3rem] bg-slate-50 flex items-center justify-center text-slate-200 animate-pulse">
                                                <i data-lucide="database" class="w-12 h-12"></i>
                                            </div>
                                            <div
                                                class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-white shadow-xl flex items-center justify-center">
                                                <i data-lucide="alert-circle" class="w-4 h-4 text-[#D4AF37]"></i>
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <h3 class="text-2xl font-black text-slate-900">Operational Vacancy</h3>
                                            <p class="text-[10px] uppercase font-black tracking-widest text-slate-400">No
                                                project nodes discovered in the current registry subset.</p>
                                        </div>
                                        <a href="{{ route('admin.projects.create') }}"
                                            class="px-8 py-3 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-xl shadow-slate-900/10 hover:scale-105 active:scale-95 transition-all">
                                            Initialize First Protocol
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Enhanced Footer -->
            <div
                class="p-10 border-t border-slate-50 flex items-center justify-between bg-slate-50/30 backdrop-blur-sm">
                <div class="flex items-center gap-4">
                    <div class="flex -space-x-3">
                        @foreach(range(1, 4) as $i)
                            <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-200 overflow-hidden shadow-sm">
                                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ $i }}" alt="User">
                            </div>
                        @endforeach
                        <div
                            class="w-8 h-8 rounded-full border-2 border-white bg-[#D4AF37] flex items-center justify-center text-[8px] font-black text-white shadow-md">
                            +12</div>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Registry active and
                        synced by core team.</p>
                </div>

                <div class="flex items-center gap-3">
                    <button
                        class="group/nav w-12 h-12 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 hover:border-[#D4AF37] hover:text-[#D4AF37] hover:shadow-lg hover:shadow-amber-100 transition-all duration-300">
                        <i data-lucide="chevron-left"
                            class="w-5 h-5 group-hover/nav:-translate-x-0.5 transition-transform"></i>
                    </button>
                    <div class="flex items-center gap-2 px-4 h-12 bg-white border border-slate-100 rounded-2xl">
                        <span class="text-[10px] font-black text-slate-900 tracking-widest">01</span>
                        <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">of</span>
                        <span class="text-[10px] font-black text-slate-400 tracking-widest tracking-widest">12</span>
                    </div>
                    <button
                        class="group/nav w-12 h-12 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 hover:border-[#D4AF37] hover:text-[#D4AF37] hover:shadow-lg hover:shadow-amber-100 transition-all duration-300">
                        <i data-lucide="chevron-right"
                            class="w-5 h-5 group-hover/nav:translate-x-0.5 transition-transform"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</x-app-layout>