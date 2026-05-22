<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-8 font-inter pb-20">
        <!-- Header Controls -->
        <div class="flex items-center justify-between no-print">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.transition.index') }}" 
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#00515F] hover:border-[#00515F]/20 transition-all">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-xl font-black text-slate-900 tracking-tight">Transition Plan Details</h1>
                    <p class="text-xs text-slate-400 font-medium">Official succession transition record and endorsement.</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button onclick="window.print()" 
                        class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-slate-900 hover:border-slate-300 transition-all"
                        title="Print Plan">
                    <i data-lucide="printer" class="w-5 h-5"></i>
                </button>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.transition.edit', $transition) }}" 
                       class="bg-[#00515F] hover:bg-[#00333B] text-white px-5 py-2.5 rounded-xl font-bold text-xs flex items-center gap-2 transition-all shadow-sm">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        Edit Plan
                    </a>
                @endif
            </div>
        </div>

        <x-hr-approval-banner :record="$transition" module="transition" class="no-print" />

        <!-- Main Document Container (Designed to look premium and printable) -->
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl overflow-hidden print:border-0 print:shadow-none p-10 md:p-16 space-y-12 relative">
            <!-- Decorative Branding Element -->
            <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-[#00515F] via-[#00ADC5] to-[#00333B]"></div>

            <!-- Title Header Block -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-slate-100 pb-8">
                <div>
                    <div class="text-[10px] font-black uppercase tracking-[0.2em] text-[#00ADC5] mb-1">Human Resources Succession Planning</div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">TRANSITION PLAN FORM</h2>
                </div>
                <div class="text-right flex flex-col md:items-end gap-1.5">
                    @php
                        $statusColors = [
                            'Planned' => 'bg-blue-50 text-blue-600 border-blue-100',
                            'In Progress' => 'bg-amber-50 text-amber-600 border-amber-100',
                            'Completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                            'Delayed' => 'bg-rose-50 text-rose-600 border-rose-100',
                        ];
                        $color = $statusColors[$transition->status] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                    @endphp
                    <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $color }}">
                        {{ $transition->status }}
                    </span>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Date Created: {{ $transition->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <!-- Plan Parameters (Department) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-slate-50/50 rounded-3xl p-6 border border-slate-100">
                <div>
                    <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Department</div>
                    <p class="text-sm font-black text-slate-800 uppercase tracking-wide">{{ $transition->department }}</p>
                </div>
                <div>
                    <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Created By</div>
                    <p class="text-sm font-bold text-slate-700">{{ $transition->creator ? $transition->creator->name : 'System Admin' }}</p>
                </div>
            </div>

            <!-- Transition Plan Items Table -->
            <div class="space-y-4">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-[#00515F] rounded-full"></span>
                    Planned Key Handovers
                </h3>
                
                <div class="border border-slate-200 rounded-3xl overflow-hidden">
                    <table class="w-full border-collapse text-left">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center w-20">No.</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Critical Role</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Current Holder</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Successor</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right w-44">Transition Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @foreach($transition->items as $item)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 text-center font-black text-[#00515F] bg-slate-50/30">{{ $item->row_number }}</td>
                                    <td class="px-6 py-4 font-bold text-slate-900">{{ $item->critical_role }}</td>
                                    <td class="px-6 py-4 font-medium text-slate-600">{{ $item->current_holder }}</td>
                                    <td class="px-6 py-4 font-bold text-[#00ADC5]">{{ $item->successor }}</td>
                                    <td class="px-6 py-4 text-right font-black text-slate-700 text-xs">
                                        {{ date('M d, Y', strtotime($item->transition_date)) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Signature & Authorization -->
            <div class="pt-8 border-t border-slate-100">
                <div class="max-w-xs ml-auto text-center space-y-4">
                    <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Authorized Signature</div>
                    
                    @if($transition->signature_path)
                        <div class="p-4 border border-slate-100 rounded-3xl bg-slate-50 flex items-center justify-center">
                            <img src="{{ \App\Support\StorageUrl::public($transition->signature_path) }}" class="max-h-24 object-contain" alt="Signature Preview">
                        </div>
                    @else
                        <div class="h-24 border border-dashed border-slate-200 rounded-3xl flex items-center justify-center text-[10px] font-black uppercase text-slate-300">
                            No Signature Authorized
                        </div>
                    @endif
                    
                    <div class="border-t border-slate-200 pt-2">
                        <p class="text-xs font-black text-slate-900 uppercase tracking-widest">{{ $transition->creator ? $transition->creator->name : 'System Admin' }}</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Executive HR Sign-off</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Custom Styles -->
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
            }
        }
    </style>
</x-app-layout>
