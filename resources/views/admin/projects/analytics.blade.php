<x-app-layout>
    <div class="py-10 px-6 space-y-12 max-w-[1700px] mx-auto font-inter">

        <!-- Modern Compact Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 pb-4 border-b border-slate-100">
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center text-white shadow-xl shadow-slate-900/20">
                        <i data-lucide="bar-chart-3" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-light text-slate-400 tracking-tight font-outfit leading-none">
                            Portfolio <span class="font-black text-slate-900">Intelligence</span>
                        </h2>
                        <p class="text-[10px] font-black text-[#D4AF37] uppercase tracking-[0.3em] mt-2">Macro-level
                            reconnaissance & financial equilibrium</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- Node sync removed -->

                <button onclick="window.print()"
                    class="group/btn relative px-8 py-3.5 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest overflow-hidden transition-all hover:scale-105 active:scale-95 shadow-xl shadow-slate-900/20">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-[#D4AF37] to-blue-500 translate-x-[-100%] group-hover/btn:translate-x-0 transition-transform duration-500">
                    </div>
                    <span class="relative flex items-center gap-2">
                        <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                        Generate Report
                    </span>
                </button>
            </div>
        </div>

        <!-- Metric Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <!-- Metric 1 -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-50 relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 w-20 h-20 bg-amber-50 rounded-full blur-2xl group-hover:bg-cyan-100 transition-all">
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 relative z-10">Total
                    Portfolio Value</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tighter relative z-10">
                    <span
                        class="text-xs font-bold text-slate-400 mr-1">ETB</span>{{ number_format($totalPortfolioValue / 1000000, 1) }}M
                </h3>
                <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between relative z-10">
                    <span class="text-[9px] font-black text-emerald-500 uppercase flex items-center gap-1">
                        <i data-lucide="trending-up" class="w-2 h-2"></i>
                        +{{ number_format($totalVariations / 1000000, 1) }}M Variations
                    </span>
                </div>
            </div>

            <!-- Metric 2 -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-50 relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 w-20 h-20 bg-indigo-50 rounded-full blur-2xl group-hover:bg-indigo-100 transition-all">
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 relative z-10">Allowable
                    Cost</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tighter relative z-10">
                    <span
                        class="text-xs font-bold text-slate-400 mr-1">ETB</span>{{ number_format($totalAllowableCost / 1000000, 1) }}M
                </h3>
                <div class="mt-4 pt-4 border-t border-slate-50 relative z-10">
                    <div class="w-full bg-slate-50 h-1.5 rounded-full overflow-hidden border border-slate-100">
                        <div class="bg-indigo-500 h-full rounded-full"
                            style="width: {{ ($totalAllowableCost / $totalPortfolioValue) * 100 }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Metric 3 -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-50 relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 w-20 h-20 bg-amber-50 rounded-full blur-2xl group-hover:bg-amber-100 transition-all">
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 relative z-10">Cost at
                    Completion</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tighter relative z-10">
                    <span
                        class="text-xs font-bold text-slate-400 mr-1">ETB</span>{{ number_format($totalCostAtCompletion / 1000000, 1) }}M
                </h3>
                <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between relative z-10">
                    <span class="text-[9px] font-black text-amber-500 uppercase tracking-widest">Projection</span>
                    <i data-lucide="eye" class="w-3 h-3 text-slate-300"></i>
                </div>
            </div>

            <!-- Metric 4 (Lighter implementation of dark card) -->
            <div
                class="bg-gradient-to-br from-[#D4AF37] to-cyan-600 p-8 rounded-[2.5rem] shadow-xl shadow-amber-100 flex flex-col justify-between border border-cyan-400/20 relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all">
                </div>
                <p class="text-[10px] font-black text-white/70 uppercase tracking-widest mb-4 relative z-10">Financial
                    Equilibrium</p>
                <h3 class="text-2xl font-black text-white tracking-tighter relative z-10">
                    <span
                        class="text-xs font-bold text-white/50 mr-1">ETB</span>{{ number_format($costVariance / 1000000, 1) }}M
                </h3>
                <p
                    class="text-[9px] font-black text-white uppercase mt-4 tracking-[0.2em] relative z-10 bg-white/10 w-fit px-2 py-1 rounded-lg">
                    Performance Surplus</p>
            </div>

            <!-- Metric 5 -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-50 relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 w-20 h-20 bg-rose-50 rounded-full blur-2xl group-hover:bg-rose-100 transition-all">
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 relative z-10">Temporal
                    Variance</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tighter relative z-10">
                    {{ number_format($avgScheduleVariance, 1) }} <span
                        class="text-xs font-bold text-slate-400 ml-1">Days</span>
                </h3>
                <div class="mt-4 pt-4 border-t border-slate-50 flex items-center gap-2 relative z-10">
                    <i data-lucide="alert-circle" class="w-3 h-3 text-rose-400"></i>
                    <span class="text-[9px] font-black text-rose-400 uppercase">Avg Drift Ratio</span>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Strategic Value Distribution (Bar Chart) -->
            <div class="lg:col-span-2 bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-8">
                <div class="flex items-center justify-between px-2">
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight font-outfit">Portfolio Asset Value
                        </h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Value
                            distribution by Project Node</p>
                    </div>
                </div>
                <div class="h-[400px] w-full">
                    <canvas id="portfolioValueChart"></canvas>
                </div>
            </div>

            <!-- Sector Concentration (Doughnut Chart) -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 flex flex-col justify-between">
                <div class="space-y-2 px-2">
                    <h3 class="text-xl font-black text-slate-900 tracking-tight font-outfit">Sector Distribution</h3>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Portfolio allocation by
                        industry sector</p>
                </div>
                <div class="h-[300px] w-full flex items-center justify-center">
                    <canvas id="sectorDistributionChart"></canvas>
                </div>
                <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100 space-y-3">
                    @foreach($sectorValues as $sector => $value)
                        <div class="flex items-center justify-between text-[10px] font-bold">
                            <span class="text-slate-500 uppercase tracking-wider">{{ $sector }}</span>
                            <span
                                class="text-slate-900">{{ number_format(($value / $totalPortfolioValue) * 100, 1) }}%</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Client Value Table -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-8">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900 tracking-tight">Top Stakeholders</h3>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">By asset value
                            contribution</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($clientValues->take(5) as $client => $value)
                        <div
                            class="group flex items-center justify-between p-4 hover:bg-slate-50 rounded-2xl transition-all border border-transparent hover:border-slate-100">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-indigo-500 group-hover:text-white transition-all">
                                    <span class="text-[10px] font-black">{{ substr($client, 0, 1) }}</span>
                                </div>
                                <span class="text-xs font-black text-slate-700">{{ $client }}</span>
                            </div>
                            <span class="text-xs font-mono font-black text-slate-900">ETB
                                {{ number_format($value / 1000000, 1) }}M</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Project Type Performance -->
            <div class="lg:col-span-2 bg-white p-10 rounded-[3rem] shadow-sm border border-slate-50 space-y-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <i data-lucide="zap" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900 tracking-tight">Module Performance</h3>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Financial
                                synchronization by project type</p>
                        </div>
                    </div>
                </div>

                <div class="h-[300px] w-full">
                    <canvas id="typePerformanceChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Portfolio Value Chart
                new Chart(document.getElementById('portfolioValueChart'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($projects->pluck('project_name')->take(10)) !!},
                        datasets: [{
                            label: 'Total Project Value (ETB)',
                            data: {!! json_encode($projects->map(fn($p) => (float) $p->total_project_value)->take(10)) !!},
                            backgroundColor: '#D4AF37',
                            borderRadius: 12,
                            borderSkipped: false,
                            barThickness: 30
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { display: true, color: '#f1f5f9', drawBorder: false },
                                ticks: {
                                    font: { weight: 'bold', size: 10 },
                                    callback: function (value) { return 'ETB ' + (value / 1000000).toFixed(1) + 'M'; }
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { font: { weight: 'bold', size: 9 }, color: '#94a3b8' }
                            }
                        }
                    }
                });

                // Sector Distribution Chart
                new Chart(document.getElementById('sectorDistributionChart'), {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($sectorValues->keys()) !!},
                        datasets: [{
                            data: {!! json_encode($sectorValues->values()) !!},
                            backgroundColor: ['#D4AF37', '#6366f1', '#f59e0b', '#10b981', '#ef4444'],
                            borderWidth: 0,
                            cutout: '75%'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { font: { weight: 'bold', size: 10 }, usePointStyle: true, padding: 20 } }
                        }
                    }
                });

                // Type Performance Chart
                new Chart(document.getElementById('typePerformanceChart'), {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($projectTypes->keys()) !!},
                        datasets: [{
                            label: 'Project Count',
                            data: {!! json_encode($projectTypes->values()) !!},
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 4,
                            pointRadius: 6,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#10b981',
                            pointBorderWidth: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { weight: 'bold' } } },
                            x: { grid: { display: false }, ticks: { font: { weight: 'bold', size: 9 } } }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>