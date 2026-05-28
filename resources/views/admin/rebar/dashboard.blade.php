<x-app-layout>
    <div class="space-y-10 pb-20">
        <!-- 1. Executive Intelligence Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 pt-4">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight font-outfit">Executive Intelligence
                    Dashboard</h1>
                <p class="text-slate-500 font-medium italic mt-1">Real-time fabrication and resource analytics across
                    active operational nodes.</p>
            </div>

            <div class="flex items-center gap-4">
                <div
                    class="px-5 py-2.5 bg-[#e6f7fa] border border-cyan-100 rounded-full flex items-center gap-3 shadow-sm">
                    <div class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </div>
                    <span class="text-[10px] font-black text-[#008ea1] uppercase tracking-[0.2em]">Operational Status:
                        Live Connection</span>
                </div>
                <div class="text-right hidden md:block">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Global Sync</p>
                    <p class="text-xs font-bold text-slate-700">{{ now()->format('M d, Y • H:i:s') }}</p>
                </div>
            </div>
        </div>

        <!-- 2. Global Filter Bar -->
        <div
            class="bg-white border border-slate-200/60 rounded-2xl p-3 shadow-[0_10px_30px_rgba(0,0,0,0.03)] flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2 px-4 py-2 bg-slate-50 rounded-xl border border-slate-100">
                <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                <select
                    class="bg-transparent border-none text-xs font-bold text-slate-700 focus:ring-0 cursor-pointer min-w-[140px]">
                    <option>Current Quarter</option>
                    <option>Last 30 Days</option>
                    <option>Year to Date</option>
                </select>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-slate-50 rounded-xl border border-slate-100">
                <i data-lucide="map-pin" class="w-4 h-4 text-slate-400"></i>
                <select
                    class="bg-transparent border-none text-xs font-bold text-slate-700 focus:ring-0 cursor-pointer min-w-[140px]">
                    <option>All Project Sites</option>
                    <option>Bole Area Node</option>
                    <option>Akaki Logistics Hub</option>
                </select>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-slate-50 rounded-xl border border-slate-100">
                <i data-lucide="layers" class="w-4 h-4 text-slate-400"></i>
                <select
                    class="bg-transparent border-none text-xs font-bold text-slate-700 focus:ring-0 cursor-pointer min-w-[140px]">
                    <option>All Sectors</option>
                    <option>Foundation (Sector A)</option>
                    <option>Superstructure</option>
                </select>
            </div>
            <div class="ml-auto flex items-center gap-2">
                <button
                    class="flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-slate-50 transition-all active:scale-95 shadow-sm">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                    Export Intel
                </button>
            </div>
        </div>

        <!-- 3. Hero Metric Row -->
        <div class="grid grid-cols-1 gap-8">
            <div
                class="premium-card p-10 relative overflow-hidden group/hero border-none shadow-[0_20px_50px_rgba(0,173,197,0.1)]">
                <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
                <!-- Decorative Grid -->
                <div
                    class="absolute inset-0 opacity-10 bg-[radial-gradient(#D4AF37_1px,transparent_1px)] [background-size:20px_20px]">
                </div>

                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-10">
                    <div>
                        <p class="text-[11px] font-black text-cyan-400 uppercase tracking-[0.3em] mb-4">Core Strategic
                            Metric</p>
                        <h2 class="text-xl font-bold text-white mb-2 font-inter tracking-tight">Total Steel Required
                            This Quarter</h2>
                        <div class="flex items-baseline gap-4">
                            <span
                                class="text-7xl font-black text-white tracking-tighter font-outfit">{{ number_format($totalRequestedLength) }}</span>
                            <span class="text-2xl font-black text-cyan-400/80 uppercase tracking-tighter">Meters</span>
                        </div>
                        <div class="mt-6 flex items-center gap-3">
                            <div
                                class="px-3 py-1 bg-emerald-500/20 border border-emerald-500/30 rounded-full flex items-center gap-2">
                                <i data-lucide="trending-up" class="w-3.5 h-3.5 text-emerald-400"></i>
                                <span class="text-[10px] font-black text-emerald-400 tracking-widest">+14.2% VS PREVIOUS
                                    QTR</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="hidden lg:block w-72 h-32 bg-white/5 backdrop-blur-md rounded-3xl border border-white/10 p-6">
                        <p class="text-[9px] font-black text-white/40 uppercase tracking-widest mb-4">AI Predictive
                            Insight</p>
                        <p class="text-sm font-medium text-white/90 leading-relaxed italic">"Current consumption trends
                            suggest a stock replenish will be required within the next <span
                                class="text-cyan-400 font-bold">18 days</span> based on active fabrication nodes."</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Upgraded KPI Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
                $efficiency = $totalRequestedLength > 0 ? round(($steelSaved * 1000 / $totalRequestedLength) * 100, 1) : 0;
                $kpis = [
                    ['label' => 'Material Strategic Load', 'value' => number_format($totalRequestedLength), 'unit' => 'Meters', 'icon' => 'construction', 'color_from' => '#D4AF37', 'color_to' => '#06b6d4', 'insight' => 'Project load up 12.4% vs baseline'],
                    ['label' => 'Off-cut Reservoir', 'value' => $availableOffcuts, 'unit' => 'Units', 'icon' => 'database', 'color_from' => '#10b981', 'color_to' => '#34d399', 'insight' => 'Inventory health: Optimal'],
                    ['label' => 'Cumulative Steel Recovery', 'value' => number_format($steelSaved), 'unit' => 'Meters', 'icon' => 'recycle', 'color_from' => '#f59e0b', 'color_to' => '#fbbf24', 'insight' => 'Steel reused from previous cuts'],
                    ['label' => 'Current Scrap Volume', 'value' => number_format($totalScrap), 'unit' => 'Meters', 'icon' => 'trash-2', 'color_from' => '#f43f5e', 'color_to' => '#fb7185', 'insight' => 'Wastage rate stabilized at 2.4%'],
                ];
            @endphp

            @foreach($kpis as $kpi)
                <div class="premium-card group relative p-8 border-none overflow-hidden">
                    <div
                        class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[{{ $kpi['color_from'] }}] to-[{{ $kpi['color_to'] }}]">
                    </div>
                    <div class="flex flex-col gap-6">
                        <div class="flex items-center justify-between">
                            <div
                                class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center border border-slate-100 group-hover:bg-white group-hover:scale-110 transition-all duration-500">
                                <i data-lucide="{{ $kpi['icon'] }}" style="color: {{ $kpi['color_from'] }}"
                                    class="w-7 h-7"></i>
                            </div>
                            <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-300"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">
                                {{ $kpi['label'] }}
                            </p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl font-black text-slate-900 tracking-tighter">{{ $kpi['value'] }}</span>
                                <span class="text-xs font-black text-slate-400 uppercase">{{ $kpi['unit'] }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 pt-4 border-t border-slate-50">
                            <div class="w-1.5 h-1.5 rounded-full bg-[{{ $kpi['color_from'] }}]"></div>
                            <p class="text-[10px] font-bold text-slate-500 italic">{{ $kpi['insight'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- 5. Main Trend Graph -->
            <div class="lg:col-span-8 premium-card p-10 relative overflow-hidden group">
                <div class="relative z-10">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-6">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight font-outfit">Fabrication
                                    Pulse</h3>
                                <span
                                    class="px-2 py-0.5 bg-amber-50 text-[#D4AF37] border border-cyan-100 rounded-md text-[9px] font-black uppercase tracking-widest">Live
                                    Flow</span>
                            </div>
                            <p class="text-sm font-medium text-slate-500 italic">Steel demand movement across
                                operational sites</p>
                        </div>
                        <div class="flex items-center gap-6">
                            <div class="flex flex-col text-right">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Overall
                                    Efficiency</span>
                                <span class="text-2xl font-black text-emerald-500">{{ $efficiency }}%</span>
                            </div>
                            <div
                                class="p-3 bg-slate-50 rounded-2xl border border-slate-100 text-slate-400 hover:text-[#D4AF37] transition-all cursor-pointer">
                                <i data-lucide="maximize-2" class="w-5 h-5"></i>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-emerald-50/50 border border-emerald-100/50 rounded-2xl p-4 mb-8 flex items-center gap-4 animate-pop-in">
                        <div
                            class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-lg shadow-emerald-200">
                            <i data-lucide="sparkles" class="w-5 h-5"></i>
                        </div>
                        <p class="text-xs font-bold text-emerald-800">
                            <span class="font-black uppercase tracking-widest mr-2">Intelligence Insight:</span>
                            Steel demand increased <span class="font-black">12.4%</span> vs last month, showing
                            accelerated superstructure growth across Site Node B.
                        </p>
                    </div>

                    <div class="h-96 w-full">
                        <canvas id="usageChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- 6. Operational Intelligence Panel -->
            <div class="lg:col-span-4 flex flex-col gap-8">
                <div
                    class="premium-card p-10 bg-slate-900 border-none relative overflow-hidden flex-1 shadow-[0_20px_50px_rgba(15,23,42,0.2)]">
                    <div class="absolute -top-32 -right-32 w-80 h-80 bg-[#D4AF37]/10 rounded-full blur-[100px]"></div>

                    <div class="relative z-10 flex flex-col h-full">
                        <div class="mb-10">
                            <h3 class="text-xl font-black text-white tracking-tight font-outfit">Resource Strategic Mix
                            </h3>
                            <p class="text-xs font-bold text-cyan-400/60 uppercase tracking-widest mt-1 italic">
                                Automated inventory lifecycle analysis</p>
                        </div>

                        <div class="flex-1 flex items-center justify-center relative py-10 min-h-[300px]">
                            <canvas id="statusChart"></canvas>
                            <div class="absolute flex flex-col items-center pointer-events-none">
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Total
                                    Nodes</span>
                                <span
                                    class="text-5xl font-black text-white tracking-tighter">{{ array_sum($offcutStats) }}</span>
                            </div>
                        </div>

                        <div class="mt-10 space-y-4">
                            @foreach(['Available' => ['emerald', 'Stock Active'], 'Used' => ['blue', 'Deployed'], 'Scrap' => ['rose', 'Wastage']] as $label => $config)
                                <div
                                    class="flex items-center justify-between px-6 py-4 rounded-2xl bg-white/5 border border-white/[0.03] group hover:bg-white/10 transition-all duration-300">
                                    <div class="flex items-center gap-4">
                                        <div class="w-2 h-2 rounded-full bg-{{ $config[0] }}-500 animate-pulse"></div>
                                        <span
                                            class="text-[11px] font-black text-slate-300 uppercase tracking-[0.2em]">{{ $config[1] }}</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="text-lg font-black text-white">{{ $offcutStats[$label] ?? 0 }}</span>
                                        <div class="w-1 h-8 bg-white/5 rounded-full overflow-hidden">
                                            @php $p = array_sum($offcutStats) > 0 ? ($offcutStats[$label] ?? 0) / array_sum($offcutStats) * 100 : 0; @endphp
                                            <div class="w-full bg-{{ $config[0] }}-500 transition-all duration-1000"
                                                style="height: {{ $p }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="premium-card p-8 border-none bg-gradient-to-br from-[#D4AF37] to-cyan-600 text-white">
                    <h4 class="text-xs font-black uppercase tracking-[0.3em] mb-6 opacity-60">Operational Insights</h4>
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                                <i data-lucide="map-pin" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p
                                    class="text-[10px] font-black uppercase tracking-widest opacity-60 leading-none mb-1">
                                    Highest Demand Site</p>
                                <p class="text-sm font-black italic">Akaki Hub (Cluster 4)</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                                <i data-lucide="ruler" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p
                                    class="text-[10px] font-black uppercase tracking-widest opacity-60 leading-none mb-1">
                                    Most Used Diameter</p>
                                <p class="text-sm font-black italic">14mm Rebar</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                                <i data-lucide="trending-up" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p
                                    class="text-[10px] font-black uppercase tracking-widest opacity-60 leading-none mb-1">
                                    Efficiency Trend</p>
                                <p class="text-sm font-black italic">Steadily Upward (+4%)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- 7. Structural Load Intelligence -->
            <div class="premium-card p-10 overflow-hidden relative">
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight font-outfit">Structural Architecture
                            Load</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Primary
                            element volume distribution</p>
                    </div>
                    <div class="flex items-center gap-2 px-3 py-1 bg-slate-50 rounded-full border border-slate-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Top 5
                            Elements</span>
                    </div>
                </div>
                <div class="space-y-10">
                    @foreach($topElements as $el)
                        @php $percent = $totalRequestedLength > 0 ? ($el->volume / $totalRequestedLength) * 100 : 0; @endphp
                        <div class="space-y-3 group">
                            <div class="flex justify-between items-end">
                                <span
                                    class="text-xs font-black text-slate-700 uppercase tracking-[0.2em] group-hover:text-[#D4AF37] transition-colors">{{ $el->structural_element }}</span>
                                <div class="text-right">
                                    <span
                                        class="text-xs font-black text-slate-900 block tracking-tighter">{{ number_format($el->volume) }}m</span>
                                    <span class="text-[9px] font-black text-slate-400 opacity-60">{{ round($percent, 1) }}%
                                        Share</span>
                                </div>
                            </div>
                            <div
                                class="h-3 bg-slate-50 rounded-full overflow-hidden border border-slate-100 shadow-inner p-0.5">
                                <div class="h-full bg-gradient-to-r from-[#D4AF37] to-cyan-400 rounded-full transition-all duration-1000 shadow-[0_0_10px_rgba(0,173,197,0.3)]"
                                    style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 8. Real-time Log Stream -->
            <div class="premium-card p-10 overflow-hidden border-none shadow-[0_20px_60px_rgba(0,0,0,0.05)]">
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight font-outfit">Live Fabrication Stream
                        </h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Real-time node
                            deployment activity</p>
                    </div>
                    <a href="{{ route('admin.rebar.cutting-logs.index') }}"
                        class="px-6 py-2.5 bg-[#FFF8E7] text-[#D4AF37] rounded-xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-[#D4AF37] hover:text-white transition-all">Protocol
                        Feed</a>
                </div>

                <div class="space-y-6">
                    @forelse($recentFabrications as $log)
                        <div
                            class="flex items-center gap-6 p-6 rounded-3xl bg-slate-50 border border-slate-100/50 group hover:scale-[1.02] hover:bg-white hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-500">
                            <div class="relative">
                                <div
                                    class="w-16 h-16 rounded-2xl bg-white border border-slate-200 flex flex-col items-center justify-center shrink-0 shadow-sm transition-transform group-hover:rotate-6">
                                    <span
                                        class="text-lg font-black text-[#D4AF37] leading-none">{{ $log->bar_diameter }}</span>
                                    <span
                                        class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-0.5">MM</span>
                                </div>
                                <div
                                    class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white">
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-1">
                                    <p class="text-sm font-black text-slate-900 tracking-tight truncate uppercase italic">
                                        {{ $log->requirement->structural_element ?? 'Ad-hoc node' }}
                                    </p>
                                    <span
                                        class="text-[9px] font-black text-slate-300 uppercase leading-none mt-0.5">Protocol
                                        #{{ $log->id }}</span>
                                </div>
                                <p class="text-[11px] font-bold text-slate-400 flex items-center gap-2">
                                    <i data-lucide="clock" class="w-3 h-3"></i>
                                    {{ $log->date->format('M d, H:i') }} • <span
                                        class="text-slate-600">{{ number_format($log->cut_length) }}mm</span> deployment Cut
                                </p>
                            </div>
                            <div class="hidden sm:block text-right">
                                <div
                                    class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-100 shadow-sm shadow-emerald-50 transition-all group-hover:bg-emerald-500 group-hover:text-white group-hover:border-emerald-500">
                                    Verified
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="py-20 text-center flex flex-col items-center justify-center gap-4 bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                            <div class="w-16 h-16 rounded-3xl bg-white flex items-center justify-center text-slate-200">
                                <i data-lucide="activity" class="w-8 h-8"></i>
                            </div>
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">No active fabrication
                                nodes detected.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Chart.js Default Extensions
            Chart.defaults.font.family = "'Inter', 'sans-serif'";
            Chart.defaults.color = '#94a3b8';

            // Consumption Trend
            const usageCtx = document.getElementById('usageChart').getContext('2d');
            const usageData = @json($usageTrend);

            new Chart(usageCtx, {
                type: 'line',
                data: {
                    labels: Object.keys(usageData),
                    datasets: [{
                        label: 'Volume',
                        data: Object.values(usageData),
                        borderColor: '#06b6d4',
                        borderWidth: 5,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#06b6d4',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        fill: true,
                        backgroundColor: (context) => {
                            const ctx = context.chart.ctx;
                            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                            gradient.addColorStop(0, 'rgba(6, 182, 212, 0.2)');
                            gradient.addColorStop(1, 'rgba(6, 182, 212, 0)');
                            return gradient;
                        },
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [4, 4], color: '#f1f5f9' },
                            border: { display: false }
                        },
                        x: {
                            grid: { display: false },
                            border: { display: false }
                        }
                    }
                }
            });

            // Status Distribution
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            const statusData = @json($offcutStats);

            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Available', 'Used', 'Wastage'],
                    datasets: [{
                        data: [statusData['Available'] || 0, statusData['Used'] || 0, statusData['Scrap'] || 0],
                        backgroundColor: ['#10b981', '#3b82f6', '#f43f5e'],
                        hoverOffset: 15,
                        borderWidth: 0,
                        borderRadius: 10,
                        spacing: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    cutout: '82%'
                }
            });
        </script>
    @endpush
</x-app-layout>