<div class="relative" x-data="{ open: false }">
    <button @click="open = !open"
        class="relative w-10 h-10 rounded-[10px] bg-slate-50 border border-slate-200 text-slate-700 flex items-center justify-center hover:bg-amber-50 hover:text-[#D4AF37] hover:border-[#D4AF37]/25 hover:shadow-sm transition-all duration-250 active:scale-95 group">
        <i data-lucide="bell" class="w-5 h-5 transition-transform group-hover:rotate-12"></i>
        @if(Auth::user()->unreadNotifications->count() > 0)
            <span
                class="absolute top-2.5 right-2.5 w-2 h-2 bg-[#D4AF37] border-2 border-[#111111] rounded-full shadow-[0_0_8px_rgba(212,175,55,0.35)]"></span>
        @endif
    </button>

    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-[0_20px_50px_rgba(15,23,42,0.10)] border border-slate-200 overflow-hidden z-50"
        x-cloak>

        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/70">
            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">Alerts</h3>
            @if(Auth::user()->unreadNotifications->count() > 0)
                <form action="{{ route('notifications.mark-read', 'all') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="text-[9px] font-black text-[#D4AF37] uppercase tracking-tighter hover:underline">Flush
                        All</button>
                </form>
            @endif
        </div>

        <div class="max-h-[350px] overflow-y-auto custom-scrollbar">
            @forelse(Auth::user()->notifications()->latest()->limit(10)->get() as $notification)
                <div class="px-6 py-4 border-b border-slate-50 hover:bg-slate-50/50 transition-colors relative group">
                    <div class="flex gap-4">
                        <div
                            class="w-8 h-8 rounded-lg {{ $notification->read_at ? 'bg-slate-100 text-slate-500' : 'bg-amber-50 text-[#D4AF37]' }} flex items-center justify-center shrink-0">
                            <i data-lucide="{{ $notification->data['icon'] ?? 'info' }}" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[11px] font-bold text-slate-900 leading-tight mb-1 line-clamp-2">
                                {{ $notification->data['message'] ?? 'New Protocol Update' }}
                            </p>
                            <p class="text-[9px] font-medium text-slate-500">
                                {{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                        @if(!$notification->read_at)
                            <div class="w-1.5 h-1.5 rounded-full bg-[#D4AF37] mt-1 shrink-0"></div>
                        @endif
                    </div>
                    @if(!$notification->read_at)
                        <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST"
                            class="absolute inset-0 opacity-0 cursor-pointer">
                            @csrf
                            <button type="submit" class="w-full h-full cursor-pointer"></button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="py-12 px-6 text-center">
                    <div
                        class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <i data-lucide="bell-off" class="w-6 h-6"></i>
                    </div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">No Active Alerts
                    </p>
                </div>
            @endforelse
        </div>

        <a href="{{ route('notifications.index') }}"
            class="block py-3 text-center bg-slate-50/80 text-[10px] font-black text-slate-600 uppercase tracking-[0.2em] hover:bg-slate-100 transition-colors border-t border-slate-200">
            View All Terminal Logs
        </a>
    </div>
</div>