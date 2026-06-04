<aside id="sidebar"
    class="w-64 shrink-0 transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] bg-[linear-gradient(135deg,#00ADC5_0%,#083344_100%)] border-r border-[#BEEAF0] flex flex-col z-40 relative shadow-[0_10px_32px_rgba(8,51,68,0.2)] group/sidebar overflow-visible">

    <div
        class="h-16 flex items-center justify-between px-6 border-b border-white/5 shrink-0 overflow-hidden relative z-10 transition-all duration-500">
        <div class="flex items-center gap-3">
            <div
                class="w-9 h-9 bg-white/10 rounded-xl flex items-center justify-center shrink-0 border border-white/20 shadow-sm transition-transform hover:scale-110 active:scale-95 duration-300 backdrop-blur-sm">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-6 h-6 object-contain brightness-0 invert">
            </div>
            <div class="flex flex-col leading-none sidebar-text animate-pop-in">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#000000]">Succession</span>
                <span class="text-sm font-black tracking-tighter mt-0.5 text-white">Planning</span>
            </div>
        </div>
    </div>

    <!-- Floating External Toggle -->
    <button id="sidebarToggle"
        class="absolute -right-4 top-10 w-8 h-8 flex items-center justify-center rounded-full bg-white border border-[#BEEAF0] text-[#083344] hover:text-[#00ADC5] hover:scale-110 active:scale-90 transition-all duration-300 shadow-xl z-[60] group/toggle">
        <i data-lucide="chevron-left"
            class="w-4 h-4 sidebar-toggle-icon transition-transform duration-500 group-hover/toggle:translate-x-[-2px]"></i>
        <i data-lucide="chevron-right"
            class="w-4 h-4 sidebar-toggle-icon hidden transition-transform duration-500 group-hover/toggle:translate-x-[2px]"></i>
    </button>

    <nav class="flex-1 px-4 py-8 space-y-1.5 overflow-y-auto custom-scrollbar relative z-10 font-inter">
        @php
            $menu = [];

            if (Auth::check()) {
                if (Auth::user()->isAdmin() || Auth::user()->isManager() || Auth::user()->isUser() || Auth::user()->isDceo()) {
                    // 1. Dashboard
                    $menu[] = [
                        'label' => 'Dashboard',
                        'icon' => 'layout-dashboard',
                        'route' => 'admin.dashboard',
                        'active' => request()->routeIs('admin.dashboard')
                    ];

                    // 2. Critical Role & HR Planning
                    $menu[] = [
                        'label' => 'Critical Role',
                        'icon' => 'shield-check',
                        'route' => 'admin.critical-roles.index',
                        'active' => request()->routeIs('admin.critical-roles.*')
                    ];

                    $menu[] = [
                        'label' => 'Succession',
                        'icon' => 'trending-up',
                        'route' => 'admin.successions.index',
                        'active' => request()->routeIs('admin.successions.*')
                    ];

                    $menu[] = [
                        'label' => '9-Box Grid',
                        'icon' => 'grid-3x3',
                        'route' => 'admin.nine-box.index',
                        'active' => request()->routeIs('admin.nine-box.*')
                    ];

                    // Placeholders & Real Modules
                    $modules = [
                        ['label' => 'Development', 'icon' => 'user-plus', 'route' => 'admin.development.index', 'active' => request()->routeIs('admin.development.*')],
                        ['label' => 'Training', 'icon' => 'graduation-cap', 'route' => 'admin.training.index', 'active' => request()->routeIs('admin.training.*')],
                        ['label' => 'Mentor', 'icon' => 'users', 'route' => 'admin.mentor.index', 'active' => request()->routeIs('admin.mentor.*')],
                        ['label' => 'Coaching', 'icon' => 'message-square', 'route' => 'admin.coaching.index', 'active' => request()->routeIs('admin.coaching.*')],
                        ['label' => 'Progress', 'icon' => 'bar-chart-2', 'route' => 'admin.progress.index', 'active' => request()->routeIs('admin.progress.*')],
                        ['label' => 'Succession Panel', 'icon' => 'layers', 'route' => 'admin.sd.index', 'active' => request()->routeIs('admin.sd.*')],
                        ['label' => 'Leadership', 'icon' => 'award', 'route' => 'admin.leadership.index', 'active' => request()->routeIs('admin.leadership.*')],
                        ['label' => 'Transition', 'icon' => 'refresh-ccw', 'route' => 'admin.transition.index', 'active' => request()->routeIs('admin.transition.*')],
                    ];

                    if (Auth::user()->isAdmin()) {
                        $modules[] = ['label' => 'Report', 'icon' => 'file-bar-chart', 'route' => 'admin.reports.index', 'active' => request()->routeIs('admin.reports.*')];
                    }

                    foreach ($modules as $m) {
                        $menu[] = [
                            'label' => $m['label'],
                            'icon' => $m['icon'],
                            'route' => $m['route'],
                            'active' => $m['active']
                        ];
                    }

                    // 3. Access Control
                    if (Auth::user()->isAdmin()) {
                        $menu[] = [
                            'label' => 'Access Control',
                            'icon' => 'users-2',
                            'route' => 'admin.roles.index',
                            'active' => request()->routeIs('admin.roles.*') || request()->routeIs('admin.users.*')
                        ];
                    }
                }
            }
        @endphp

        @foreach ($menu as $item)
            <a href="{{ route($item['route']) }}"
                class="flex items-center gap-3.5 p-3 rounded-xl transition-all duration-300 ease-out group/item relative 
                                                                                    {{ $item['active'] ? 'bg-white text-[#083344] shadow-lg shadow-[#083344]/10 z-20 translate-x-1' : 'hover:bg-white/15 text-white/85 hover:text-white hover:translate-x-1' }}">

                @if($item['active'])
                    <div class="absolute inset-y-2.5 -left-1 w-1 bg-[#083B44] rounded-full shadow-[0_0_10px_#00ADC5]">
                    </div>
                @endif

                <i data-lucide="{{ $item['icon'] }}"
                    class="w-5 h-5 shrink-0 transition-all duration-300 {{ $item['active'] ? 'stroke-[2.5px] scale-110' : 'opacity-70 group-hover/item:opacity-100 group-hover/item:scale-110' }}"></i>

                <span
                    class="sidebar-text font-medium text-sm whitespace-nowrap tracking-tight transition-all duration-300">{{ $item['label'] }}</span>

                @if(isset($item['unread']) && $item['unread'] > 0)
                    <span
                        class="ml-auto bg-white/20 text-white text-[10px] font-black px-2 py-0.5 rounded-lg sidebar-text animate-pulse">
                        {{ $item['unread'] }}
                    </span>
                @endif
            </a>
        @endforeach
    </nav>

    @if(Auth::check())
    <div class="p-6 border-t border-white/5 shrink-0 relative z-10 transition-all duration-500">
        <a href="{{ route('admin.settings.index') }}"
            class="flex items-center gap-3.5 p-3 w-full rounded-xl transition-all duration-300 ease-out text-white/85 hover:text-white hover:bg-white/15 group/settings {{ request()->routeIs('admin.settings.index') ? 'bg-[#083344]/15 text-white border border-[#BEEAF0] shadow-lg shadow-[#083344]/10' : 'bg-[#0a94a8]' }}"
            title="Settings">
            <i data-lucide="settings"
                class="w-5 h-5 shrink-0 group-hover/settings:rotate-45 transition-all duration-500 {{ request()->routeIs('admin.settings.index') ? 'stroke-[2.5px] scale-110' : 'opacity-70 group-hover/settings:opacity-100 group-hover/settings:scale-110' }}"></i>
            <span class="sidebar-text font-medium text-sm whitespace-nowrap tracking-tight transition-all duration-300">Settings</span>
        </a>
    </div>
    @endif
</aside>

<style>
    @keyframes pop-in {
        0% {
            opacity: 0;
            transform: scale(0.9) translateX(-10px);
        }

        100% {
            opacity: 1;
            transform: scale(1) translateX(0);
        }
    }

    .animate-pop-in {
        animation: pop-in 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    #sidebar.w-20 .sidebar-text {
        display: none !important;
    }

    #sidebar.w-20 .h-16 {
        justify-content: center;
        padding: 0;
    }

    /* Fixed logo center in collapsed mode */
    #sidebar.w-20 .h-16 .flex.items-center.gap-3 {
        gap: 0;
    }

    #sidebar.w-20 nav {
        padding-left: 0;
        padding-right: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    #sidebar.w-20 nav a {
        justify-content: center;
        width: 48px;
        height: 48px;
        padding: 0;
        margin: 0 auto;
    }

    #sidebar.w-20 .p-6 {
        padding: 1.5rem 0;
        display: flex;
        justify-content: center;
    }

    #sidebar.w-20 .p-6 a {
        justify-content: center;
        width: 48px;
        height: 48px;
        padding: 0;
        margin: 0 auto;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }
</style>