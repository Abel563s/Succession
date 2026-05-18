<x-app-layout>
    <div class="py-6 space-y-6">
        <!-- Dashboard Header -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div
                class="px-8 py-10 flex flex-col md:flex-row md:items-center justify-between gap-8 bg-gradient-to-br from-white to-slate-50/50">
                <div class="space-y-2">
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                        Welcome, <span class="text-[#00ADC5]">{{ Auth::user()->name }}</span>
                    </h2>
                    <p class="text-slate-500 font-medium">
                        Welcome to the Critical Role Management System. Use the sidebar to navigate.
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <div
                        class="bg-white border border-slate-200 rounded-2xl px-5 py-3 shadow-sm flex flex-col items-end">
                        <span
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">System
                            Time</span>
                        <span class="text-lg font-bold text-slate-700">{{ now()->format('h:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State / Landing -->
        <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
            <div class="w-20 h-20 bg-[#f0fbfd] rounded-full flex items-center justify-center mb-6 border border-[#00ADC5]/10">
                <i data-lucide="layout-dashboard" class="w-10 h-10 text-[#00ADC5]"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Ready to manage critical roles</h3>
            <p class="text-slate-500 max-w-sm mx-auto">
                Select "Critical Role" from the sidebar to start managing employee evaluations and succession planning.
            </p>
        </div>
    </div>
</x-app-layout>