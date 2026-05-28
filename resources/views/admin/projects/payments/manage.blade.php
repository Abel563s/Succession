<x-app-layout>
    <div class="py-10 px-6 space-y-8 max-w-[1700px] mx-auto font-inter">
        <!-- Modern Compact Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 pb-4 border-b border-slate-100">
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.projects.payments.index') }}"
                        class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-[#D4AF37] hover:border-[#D4AF37]/20 hover:rotate-[-10deg] transition-all shadow-sm">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>
                    <div>
                        <h2 class="text-3xl font-light text-slate-400 tracking-tight font-outfit leading-none">
                            Payment <span class="font-black text-slate-900">Protocols</span>
                        </h2>
                        <p class="text-[10px] font-black text-[#D4AF37] uppercase tracking-[0.3em] mt-2">
                            {{ $project->project_name }} - {{ $project->custom_id }}</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button onclick="document.getElementById('addPaymentForm').scrollIntoView({behavior: 'smooth'})"
                    class="group/btn relative px-6 py-3.5 bg-white border border-slate-100 text-slate-600 rounded-2xl font-black text-[10px] uppercase tracking-widest overflow-hidden transition-all hover:bg-slate-50 active:scale-95 shadow-sm">
                    <span class="relative flex items-center gap-2">
                        <i data-lucide="plus" class="w-3.5 h-3.5 text-[#D4AF37]"></i>
                        New Certificate
                    </span>
                </button>

                <div
                    class="flex items-center gap-2 px-6 py-3.5 bg-slate-900 border border-slate-800 rounded-2xl shadow-xl shadow-slate-900/20">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] font-black text-white uppercase tracking-widest">Active Financials</span>
                </div>
            </div>
        </div>

        <!-- SECTION 1: Summary Dashboard Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
            <!-- Contract Value -->
            <div class="premium-card p-6 bg-gradient-to-br from-white to-slate-50">
                <div class="flex items-center gap-3 text-slate-400 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center">
                        <i data-lucide="briefcase" class="w-4 h-4"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest">Contract Value</span>
                </div>
                <p class="text-2xl font-black text-slate-900">${{ number_format($contractValue, 2) }}</p>
                <div class="mt-2 flex items-center gap-1 text-[10px] font-bold text-slate-400">
                    <i data-lucide="info" class="w-3 h-3"></i>
                    Total Project Value
                </div>
            </div>

            <!-- Total Certified -->
            <div class="premium-card p-6 bg-gradient-to-br from-white to-slate-50">
                <div class="flex items-center gap-3 text-slate-400 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                        <i data-lucide="award" class="w-4 h-4"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest">Total Certified</span>
                </div>
                <p class="text-2xl font-black text-amber-600">${{ number_format($totalCertified, 2) }}</p>
                <div class="mt-2 flex items-center gap-1 text-[10px] font-bold text-slate-400">
                    <i data-lucide="trending-up" class="w-3 h-3 text-amber-500"></i>
                    Work Completed
                </div>
            </div>

            <!-- Total Paid -->
            <div class="premium-card p-6 bg-gradient-to-br from-white to-slate-50">
                <div class="flex items-center gap-3 text-slate-400 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest">Total Paid</span>
                </div>
                <p class="text-2xl font-black text-emerald-600">${{ number_format($totalPaid, 2) }}</p>
                <div class="mt-2 flex items-center gap-1 text-[10px] font-bold text-emerald-500">
                    <i data-lucide="arrow-down-right" class="w-3 h-3"></i>
                    Disbursed Amount
                </div>
            </div>

            <!-- Total Submitted -->
            <div class="premium-card p-6 bg-gradient-to-br from-white to-slate-50">
                <div class="flex items-center gap-3 text-slate-400 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <i data-lucide="send" class="w-4 h-4"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest">Total Submitted</span>
                </div>
                <p class="text-2xl font-black text-indigo-600">${{ number_format($totalSubmitted, 2) }}</p>
                <div class="mt-2 flex items-center gap-1 text-[10px] font-bold text-slate-400">
                    <i data-lucide="file-text" class="w-3 h-3 text-indigo-500"></i>
                    Claims Submitted
                </div>
            </div>

            <!-- Outstanding Balance -->
            <div class="premium-card p-6 bg-slate-900 border-none shadow-xl shadow-slate-900/10">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="w-8 h-8 rounded-lg bg-slate-800 text-sky-400 flex items-center justify-center border border-slate-700">
                        <i data-lucide="wallet" class="w-4 h-4"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-300">Project Balance</span>
                </div>
                <p class="text-2xl font-black text-white">${{ number_format($outstandingBalance, 2) }}</p>
                <div class="mt-2 flex items-center gap-1 text-[10px] font-bold text-slate-400">
                    <i data-lucide="info" class="w-3 h-3 text-sky-500"></i>
                    Contract vs Certified
                </div>
            </div>

            <!-- Payment Progress -->
            <div class="premium-card p-6 flex flex-col justify-between overflow-hidden relative">
                <div class="relative z-10">
                    <div class="flex items-center gap-3 text-slate-400 mb-2">
                        <span class="text-[10px] font-black uppercase tracking-widest">Progress</span>
                    </div>
                    <p class="text-2xl font-black text-sky-600 leading-none">{{ number_format($paymentProgress, 1) }}%
                    </p>
                </div>

                <div class="mt-4 relative z-10">
                    <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-sky-500 rounded-full" style="width: {{ $paymentProgress }}%"></div>
                    </div>
                </div>

                <!-- Subtle background icon -->
                <i data-lucide="activity" class="absolute -right-4 -bottom-4 w-20 h-20 text-slate-50 -rotate-12"></i>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- LEFT COLUMN: Payment History & Breakdown -->
            <div class="xl:col-span-2 space-y-8">
                <!-- SECTION 3: Payment History Table -->
                <div class="premium-card overflow-hidden ring-1 ring-slate-200">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-sky-50 text-sky-600 rounded-xl flex items-center justify-center">
                                <i data-lucide="history" class="w-5 h-5"></i>
                            </div>
                            <h2 class="text-xl font-black text-slate-900 tracking-tight">Payment History</h2>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="p-2 text-slate-400 hover:text-sky-600 transition-colors"><i
                                    data-lucide="download" class="w-5 h-5"></i></button>
                            <button class="p-2 text-slate-400 hover:text-sky-600 transition-colors"><i
                                    data-lucide="filter" class="w-5 h-5"></i></button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                    <th class="px-6 py-4">Cert Details</th>
                                    <th class="px-6 py-4 text-center">Submitted</th>
                                    <th class="px-6 py-4 text-center">Certified</th>
                                    <th class="px-6 py-4 text-center">Paid</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($project->payments->sortByDesc('certificate_date') as $payment)
                                    <tr class="hover:bg-slate-50/80 transition-all group">
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col">
                                                <span
                                                    class="font-black text-slate-900">#{{ $payment->certificate_number }}</span>
                                                <span
                                                    class="text-[10px] font-bold text-slate-400 uppercase">{{ $payment->certificate_date->format('d M, Y') }}</span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            @if($payment->submitted_amount)
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-sm font-black text-indigo-600">${{ number_format($payment->submitted_amount, 2) }}</span>
                                                    <span
                                                        class="text-[10px] font-bold text-slate-400">{{ $payment->submitted_date ? $payment->submitted_date->format('d M, Y') : '-' }}</span>
                                                </div>
                                            @else
                                                <span class="text-slate-300 text-xs">-</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            @if($payment->certified_amount)
                                                <div class="flex flex-col border-x border-slate-50 px-2">
                                                    <span
                                                        class="text-sm font-black text-amber-600">${{ number_format($payment->certified_amount, 2) }}</span>
                                                    <span
                                                        class="text-[10px] font-bold text-slate-400">{{ $payment->certified_date ? $payment->certified_date->format('d M, Y') : '-' }}</span>
                                                </div>
                                            @else
                                                <span class="text-slate-300 text-xs">-</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            @if($payment->amount_paid)
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-sm font-black text-emerald-600">${{ number_format($payment->amount_paid, 2) }}</span>
                                                    <span
                                                        class="text-[10px] font-bold text-slate-400">{{ $payment->payment_date ? $payment->payment_date->format('d M, Y') : '-' }}</span>
                                                </div>
                                            @else
                                                <span class="text-slate-300 text-xs">-</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $status = $payment->status;
                                                $statusClass = [
                                                    'Paid' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                    'Partially Paid' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                    'Pending' => 'bg-rose-50 text-rose-600 border-rose-100',
                                                ][$status] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                                            @endphp
                                            <span
                                                class="px-3 py-1 rounded-full text-[10px] font-black border {{ $statusClass }} uppercase tracking-wider">
                                                {{ $status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button onclick="showPaymentDetail({{ $payment->id }})"
                                                class="p-2 bg-white border border-slate-200 rounded-lg text-slate-400 hover:text-sky-500 hover:border-sky-500 hover:shadow-sm transition-all">
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div
                                                class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-200">
                                                <i data-lucide="file-minus" class="w-8 h-8"></i>
                                            </div>
                                            <p class="font-bold text-slate-400">No payment certificates recorded yet.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECTION 5: Financial Graph (Visualization) -->
                <div class="premium-card p-6 ring-1 ring-slate-200">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center">
                            <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-slate-900 tracking-tight leading-none">Financial
                                Visualization</h2>
                            <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-widest">Payment vs
                                Outstanding</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <div
                                class="flex items-center justify-between text-xs font-black uppercase tracking-widest text-slate-400 mb-2">
                                <span>Paid Composition</span>
                                <span class="text-emerald-500 font-bold">${{ number_format($totalPaid, 2) }}</span>
                            </div>
                            <div class="h-8 w-full bg-slate-100 rounded-2xl overflow-hidden flex shadow-inner">
                                @if($contractValue > 0)
                                    <div class="h-full bg-emerald-500 relative group"
                                        style="width: {{ ($totalPaid / $contractValue) * 100 }}%">
                                        <div
                                            class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity">
                                        </div>
                                    </div>
                                    <div class="flex-1 bg-slate-200"></div>
                                @endif
                            </div>
                            <div class="flex items-center gap-4 mt-3">
                                <div
                                    class="flex items-center gap-1.5 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                    <span class="w-2 h-2 rounded bg-emerald-500"></span> Total Paid
                                </div>
                                <div
                                    class="flex items-center gap-1.5 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                    <span class="w-2 h-2 rounded bg-slate-200"></span> Outstanding Balance
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Add New Payment Form -->
            <div id="addPaymentForm" class="space-y-8">
                <div class="premium-card p-6 ring-1 ring-slate-900/5 bg-white relative overflow-hidden">
                    <!-- Form Decoration -->
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-sky-50 rounded-full blur-3xl -mr-16 -mt-16 opacity-50">
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 bg-emerald-500 text-white rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                            </div>
                            <h2 class="text-xl font-black text-slate-900 tracking-tight">Record Payment</h2>
                        </div>

                        <form action="{{ route('admin.projects.payments.store', $project) }}" method="POST"
                            class="space-y-5">
                            @csrf

                            <!-- Cert Info Row -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Cert
                                        Number</label>
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i data-lucide="hash" class="w-4 h-4"></i>
                                        </div>
                                        <input type="text" name="certificate_number" required placeholder="CERT-001"
                                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all font-bold text-slate-900 placeholder:text-slate-300">
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Cert
                                        Date</label>
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i data-lucide="calendar" class="w-4 h-4"></i>
                                        </div>
                                        <input type="date" name="certificate_date" required
                                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all font-bold text-slate-900">
                                    </div>
                                </div>
                            </div>

                            <!-- Submitted Info -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Submitted
                                        Amount</label>
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-indigo-500 font-bold">
                                            $
                                        </div>
                                        <input type="number" step="0.01" name="submitted_amount" id="submitted_amount"
                                            placeholder="0.00"
                                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all font-bold text-slate-900">
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Date
                                        Submitted</label>
                                    <input type="date" name="submitted_date"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all font-bold text-slate-900">
                                </div>
                            </div>

                            <!-- Certified Info -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black text-amber-600 uppercase tracking-widest ml-1 font-bold">Certified
                                        Amount</label>
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-amber-500 font-bold">
                                            $
                                        </div>
                                        <input type="number" step="0.01" name="certified_amount" id="certified_amount"
                                            placeholder="0.00"
                                            class="w-full pl-10 pr-4 py-3 bg-amber-50/20 border border-amber-100 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all font-black text-slate-900">
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Date
                                        Certified</label>
                                    <input type="date" name="certified_date"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all font-bold text-slate-900">
                                </div>
                            </div>

                            <!-- Paid Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black text-emerald-600 uppercase tracking-widest ml-1 font-bold">Amount
                                        Paid</label>
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-emerald-500 font-black">
                                            $
                                        </div>
                                        <input type="number" step="0.01" name="amount_paid" id="amount_paid"
                                            placeholder="0.00"
                                            class="w-full pl-10 pr-4 py-3 bg-emerald-50/20 border border-emerald-100 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all font-black text-emerald-700">
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Payment
                                        Date</label>
                                    <input type="date" name="payment_date"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all font-bold text-slate-900">
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Remarks</label>
                                <textarea name="remarks" rows="2" placeholder="Additional notes..."
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all font-medium text-slate-900"></textarea>
                            </div>

                            <button type="submit"
                                class="w-full py-4 bg-slate-900 text-white font-black rounded-xl hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20 flex items-center justify-center gap-3 group">
                                <span>Save Certificate</span>
                                <i data-lucide="arrow-right"
                                    class="w-5 h-5 transition-transform group-hover:translate-x-1"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 4: Payment Breakdown View (Modal) -->
    <div id="paymentModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm hidden animate-in fade-in duration-300">
        <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden animate-in zoom-in-95 duration-300">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <div class="flex items-center gap-3">
                    <div id="modalIcon" class="w-10 h-10 rounded-xl flex items-center justify-center">
                        <i data-lucide="file-text" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 id="modalTitle" class="text-xl font-black text-slate-900 tracking-tight leading-none">
                            Certificate Details</h3>
                        <p id="modalSubtitle"
                            class="text-slate-400 text-[10px] font-black uppercase tracking-widest mt-1">
                            Breakdown Summary</p>
                    </div>
                </div>
                <button onclick="closePaymentModal()"
                    class="w-8 h-8 rounded-full hover:bg-white text-slate-400 hover:text-slate-600 transition-all flex items-center justify-center border border-transparent hover:border-slate-200">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-4 bg-indigo-50/50 rounded-2xl border border-indigo-100">
                        <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Submitted</p>
                        <p id="modal_submitted_amount" class="text-xl font-black text-indigo-600"></p>
                        <p id="modal_submitted_date" class="text-[10px] font-bold text-indigo-400 mt-1"></p>
                    </div>
                    <div class="p-4 bg-amber-50/50 rounded-2xl border border-amber-100 font-bold">
                        <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-1">Certified</p>
                        <p id="modal_certified_amount" class="text-xl font-black text-amber-600"></p>
                        <p id="modal_certified_date" class="text-[10px] font-bold text-amber-400 mt-1"></p>
                    </div>
                    <div class="p-4 bg-emerald-50/50 rounded-2xl border border-emerald-100">
                        <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1">Total Paid</p>
                        <p id="modal_amount_paid" class="text-xl font-black text-emerald-600"></p>
                        <p id="modal_payment_date" class="text-[10px] font-bold text-emerald-400 mt-1"></p>
                    </div>
                </div>

                <div class="pt-6 border-t border-dashed border-slate-200">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Remarks</p>
                    <div class="p-4 bg-slate-50 rounded-2xl text-slate-600 font-medium text-sm border border-slate-100 italic"
                        id="modal_remarks">
                        No additional remarks recorded for this certificate.
                    </div>
                </div>

                <div id="modal_status_banner"
                    class="p-4 rounded-2xl flex items-center justify-between font-black text-sm uppercase tracking-widest">
                    <span>Current Status</span>
                    <span id="modal_status_text"></span>
                </div>
            </div>

            <div class="p-6 bg-slate-50 border-t border-slate-100 flex gap-3">
                <button onclick="closePaymentModal()"
                    class="flex-1 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-100 transition-all">Close</button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function formatDate(dateString) {
                if (!dateString) return '-';
                return new Date(dateString).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
            }

            function formatCurrency(amount) {
                return '$' + (parseFloat(amount) || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }

            // Modal Logic
            function showPaymentDetail(paymentId) {
                fetch(`/admin/payments/${paymentId}`)
                    .then(response => response.json())
                    .then(data => {
                        const modal = document.getElementById('paymentModal');

                        document.getElementById('modalTitle').textContent = `Certificate #${data.certificate_number}`;
                        document.getElementById('modalSubtitle').textContent = `Certificate Date: ${formatDate(data.certificate_date)}`;

                        document.getElementById('modal_submitted_amount').textContent = formatCurrency(data.submitted_amount);
                        document.getElementById('modal_submitted_date').textContent = data.submitted_date ? `On ${formatDate(data.submitted_date)}` : 'Not recorded';

                        document.getElementById('modal_certified_amount').textContent = formatCurrency(data.certified_amount);
                        document.getElementById('modal_certified_date').textContent = data.certified_date ? `On ${formatDate(data.certified_date)}` : 'Not recorded';

                        document.getElementById('modal_amount_paid').textContent = formatCurrency(data.amount_paid);
                        document.getElementById('modal_payment_date').textContent = data.payment_date ? `On ${formatDate(data.payment_date)}` : 'Not recorded';

                        document.getElementById('modal_remarks').textContent = data.remarks || 'No additional remarks.';

                        const banner = document.getElementById('modal_status_banner');
                        const text = document.getElementById('modal_status_text');
                        const icon = document.getElementById('modalIcon');

                        const target = parseFloat(data.certified_amount) || parseFloat(data.submitted_amount) || 0;
                        const paid = parseFloat(data.amount_paid) || 0;

                        if (target > 0 && paid >= target) {
                            banner.className = 'p-4 rounded-2xl flex items-center justify-between font-black text-sm uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100';
                            text.textContent = 'Fully Paid';
                            icon.className = 'w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-500 text-white';
                        } else if (paid > 0) {
                            banner.className = 'p-4 rounded-2xl flex items-center justify-between font-black text-sm uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100';
                            text.textContent = 'Partially Paid';
                            icon.className = 'w-10 h-10 rounded-xl flex items-center justify-center bg-amber-500 text-white';
                        } else {
                            banner.className = 'p-4 rounded-2xl flex items-center justify-between font-black text-sm uppercase tracking-widest bg-rose-50 text-rose-600 border border-rose-100';
                            text.textContent = 'Payment Pending';
                            icon.className = 'w-10 h-10 rounded-xl flex items-center justify-center bg-rose-500 text-white';
                        }

                        modal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                        if (window.lucide) lucide.createIcons();
                    });
            }

            function closePaymentModal() {
                document.getElementById('paymentModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            // Close modal on background click
            document.getElementById('paymentModal').addEventListener('click', function (e) {
                if (e.target === this) closePaymentModal();
            });
        </script>
    @endpush
    @endsection