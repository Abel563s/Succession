<x-app-layout>
    <div
        class="py-12 px-6 flex flex-col items-center justify-center min-h-[70vh] space-y-10 animate-in fade-in slide-in-from-bottom-10 duration-1000">

        <div class="relative">
            <div class="absolute -inset-10 bg-gradient-to-tr from-[#D4AF37]/20 to-[#111111]/20 blur-[60px] rounded-full">
            </div>
            <div
                class="relative w-28 h-28 bg-white rounded-[40px] shadow-2xl flex items-center justify-center border border-slate-100 group">
                <i data-lucide="shield-check"
                    class="w-14 h-14 text-[#D4AF37] group-hover:scale-110 group-hover:rotate-6 transition-all duration-500"></i>
            </div>
        </div>

        <div class="text-center space-y-4 max-w-md">
            <div
                class="flex items-center justify-center gap-2 text-[#D4AF37] font-black uppercase tracking-[0.4em] text-[10px]">
                <span class="w-12 h-[2px] bg-[#D4AF37]"></span>
                Security Node
            </div>
            <h2 class="text-4xl font-black text-slate-900 tracking-tight">Roles & <span
                    class="text-[#D4AF37]">Permissions</span></h2>
            <p class="text-slate-500 font-medium leading-relaxed">
                Management of cryptographic identity nodes and behavioral permissions is currently being synchronized
                with the core architecture.
            </p>
        </div>

        <div class="flex items-center gap-4">
            <div class="px-6 py-2 bg-slate-50 border border-slate-100 rounded-2xl flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Initialization
                    Pending</span>
            </div>
            <a href="{{ route('admin.dashboard') }}"
                class="px-8 py-3 bg-slate-900 text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] shadow-xl shadow-slate-900/20 hover:scale-[1.05] active:scale-95 transition-all">
                Return to Dashboard
            </a>
        </div>

        <div class="grid grid-cols-3 gap-6 w-full max-w-2xl mt-12 opacity-50">
            <div class="h-1 bg-slate-100 rounded-full overflow-hidden flex">
                <div class="w-2/3 h-full bg-[#D4AF37]"></div>
            </div>
            <div class="h-1 bg-slate-100 rounded-full"></div>
            <div class="h-1 bg-slate-100 rounded-full"></div>
        </div>
    </div>
</x-app-layout>