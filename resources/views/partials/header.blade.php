<header
    class="h-16 bg-white/95 border-b border-slate-200/90 flex items-center justify-between px-10 sticky top-0 z-30 shadow-[0_8px_18px_rgba(15,23,42,0.08)] backdrop-blur-xl transition-all duration-300">
    <div class="flex items-center gap-2">
        <div class="flex flex-col">
            <h1 class="text-lg font-black text-slate-900 tracking-tight leading-none font-outfit">
                @if(isset($header))
                    {{ $header }}
                @else
                    @yield('page-title', 'Succession Management')
                @endif
            </h1>
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mt-1.5 font-inter">
                @php
                    $roleLabel = match (Auth::user()->role) {
                        'admin' => 'Administrator',
                        'manager' => 'Manager',
                        default => 'User'
                    };
                @endphp
                {{ config('app.name', 'Laravel') }} • {{ $roleLabel }}
            </p>
        </div>
    </div>

    <div class="flex items-center gap-6">
        <!-- Notifications Dropdown -->
        @include('partials.notifications-dropdown')

        <div class="relative group" x-data="{ open: false }">
            <button @click="open = !open"
                class="w-10 h-10 rounded-[10px] bg-slate-50 border border-slate-200 text-slate-700 flex items-center justify-center font-black text-xs hover:border-[#D4AF37]/40 hover:bg-amber-50 transition-all duration-250 overflow-hidden group-hover:shadow-lg group-hover:shadow-amber-100">
                {{ substr(Auth::user()->name, 0, 1) }}
            </button>

            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-[0_10px_25px_rgba(15,23,42,0.10)] border border-slate-200 overflow-hidden z-50 py-1"
                x-cloak>
                <div class="px-4 py-3 border-b border-[#f3f4f6] bg-slate-50/30">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest font-inter">Identity
                        Overview</p>
                </div>
                <a href="{{ route('admin.settings.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-[#D4AF37] transition-all duration-200 font-inter">
                    <i data-lucide="settings" class="w-4 h-4"></i>
                    Settings
                </a>
                <div class="border-t border-[#f3f4f6]"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-bold text-rose-500 hover:bg-rose-50 transition-all duration-200 font-inter">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>