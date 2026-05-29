<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Attendance System'))</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Modern Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js for interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Outfit', sans-serif;
        }

        /* Premium Card Standard */
        .premium-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            border: 1px solid #e5e7eb;
            transition: all 0.25s ease;
        }

        .premium-card:hover {
            box-shadow: 0 18px 36px rgba(15, 23, 42, 0.12);
            transform: translateY(-2px);
        }

        /* Modern Inputs & Buttons */
        input,
        select,
        textarea {
            border-radius: 10px !important;
            transition: all 0.2s ease !important;
        }

        .btn-premium {
            border-radius: 10px;
            transition: all 0.25s ease;
        }

        /* Refined Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f8fafc;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #00ADC5;
        }

        /* Executive Shadows & Depth */
        .premium-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(241, 245, 249, 0.8);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .premium-card:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            transform: translateY(-6px);
        }

        /* Typography Weights */
        .text-title {
            font-weight: 700;
        }

        .text-metric {
            font-weight: 700;
            font-family: 'Outfit', sans-serif;
        }

        .text-label {
            font-weight: 500;
        }
    </style>
</head>

<body class="bg-[#F0FDFF] text-[#083344] antialiased h-full font-inter overflow-hidden">

    <div class="flex h-full w-full overflow-hidden">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 min-h-0 overflow-hidden">
            <!-- Header -->
            @include('partials.header')

            <!-- Content -->
            <main class="flex-1 min-h-0 overflow-y-auto overflow-x-hidden bg-[#F0FDFF] text-[#083344] px-8 py-8 custom-scrollbar">
                <!-- Session Alerts -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                        class="mb-6 bg-emerald-50 border border-emerald-100 rounded-2xl p-4 flex items-center justify-between shadow-sm shadow-emerald-100/50">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center">
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                            </div>
                            <p class="text-sm font-bold text-emerald-800">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show"
                        class="mb-6 bg-rose-50 border border-rose-100 rounded-2xl p-4 flex items-center justify-between shadow-sm shadow-rose-100/50 text-rose-800">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-rose-500 text-white flex items-center justify-center">
                                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                            </div>
                            <p class="text-sm font-bold">{{ session('error') }}</p>
                        </div>
                        <button @click="show = false" class="text-rose-400 hover:text-rose-600 transition-colors">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                @endif

                @if(isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>
        </div>
    </div>

    <script>
        // Sidebar State Management
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');

        // Function to update icons and classes
        function setSidebarState(collapsed) {
            const icons = document.querySelectorAll('.sidebar-toggle-icon');
            const sidebarText = document.querySelectorAll('.sidebar-text');

            if (collapsed) {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');

                sidebarText.forEach(el => el.classList.add('hidden'));

                // Update toggle direction
                icons.forEach(icon => {
                    if (icon.getAttribute('data-lucide') === 'chevron-left') icon.classList.add('hidden');
                    if (icon.getAttribute('data-lucide') === 'chevron-right') icon.classList.remove('hidden');
                });
            } else {
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');

                sidebarText.forEach(el => el.classList.remove('hidden'));

                // Update toggle direction
                icons.forEach(icon => {
                    if (icon.getAttribute('data-lucide') === 'chevron-left') icon.classList.remove('hidden');
                    if (icon.getAttribute('data-lucide') === 'chevron-right') icon.classList.add('hidden');
                });
            }

            // Re-initialize icons because we swapped orientations
            if (window.lucide) lucide.createIcons();

            localStorage.setItem('sidebar-collapsed', collapsed);
        }

        // Initialize state
        const storedState = localStorage.getItem('sidebar-collapsed') === 'true';
        setSidebarState(storedState);

        // Sidebar uses event delegation since the toggle is inside it
        sidebar.addEventListener('click', (e) => {
            if (e.target.closest('#sidebarToggle')) {
                const isCollapsed = sidebar.classList.contains('w-20');
                setSidebarState(!isCollapsed);
            }
        });

        // Initialize Lucide Icons
        if (window.lucide) lucide.createIcons();
    </script>

    @stack('scripts')

</body>

</html>