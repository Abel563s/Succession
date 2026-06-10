<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Attendance Management System') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Fonts: Outfit for titles, Inter for body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@700;800;900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            transform: translate3d(0, 0, 0);
            /* Stabilize rendering */
        }

        .font-outfit {
            font-family: 'Outfit', sans-serif;
        }

        .glass-morphism {
            background: #F7F8FA;
            border: 1px solid rgba(8, 51, 68, 0.06);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
        }

        .animated-bg {
            background: #E7ECEF;
        }

        .blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, rgba(8, 51, 68, 0.04) 0%, rgba(0, 173, 197, 0.03) 100%);
            filter: blur(80px);
            border-radius: 50%;
            z-index: 0;
            animation: float 20s infinite alternate;
            will-change: transform;
            pointer-events: none;
        }

        /* Accent button used on auth pages */
        .btn-accent {
            background: linear-gradient(135deg,#00515F 0%,#007A8F 50%,#00ADC5 100%);
            color: #fff;
            border: 2px solid transparent;
            box-shadow: 0 10px 30px rgba(0,173,197,0.25);
            transition: transform 160ms ease, box-shadow 160ms ease;
        }

        .btn-accent:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,173,197,0.25);
        }

        .btn-accent:active {
            transform: translateY(0);
        }

        @keyframes float {
            from {
                transform: translate(0, 0) scale(1);
            }

            to {
                transform: translate(60px, 60px) scale(1.1);
            }

            /* Reduced range */
        }
    </style>
</head>

<body class="min-h-screen text-white antialiased animated-bg overflow-y-auto lg:overflow-hidden relative flex flex-col justify-center">
    <!-- Abstract Background Elements -->
    <div class="blob top-[-10%] left-[-10%]"></div>
    <div class="blob bottom-[-10%] right-[-10%]"
        style="animation-delay: -10s; background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(59, 130, 246, 0.05) 100%);">
    </div>

    <div class="relative z-10 w-full flex flex-col justify-center py-4 md:py-6 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center px-4 sm:px-0">
            <!-- Logo Section -->
            <div class="mb-1.5">
                <img src="{{ asset('images/logo.png') }}" alt="WorkForce Logo"
                    class="w-12 h-12 md:w-14 md:h-14 mx-auto object-contain transform hover:scale-105 transition-transform duration-500 drop-shadow-2xl">
            </div>

            <h1 class="text-xl md:text-2xl font-black font-outfit tracking-tight mb-1 uppercase">
                <span class="text-[#00ADC5]">SUCCESSION</span> <span class="text-[#083344]">PLANNING</span>
            </h1>
            <p class="text-slate-500 font-medium tracking-wide uppercase text-[8px] tracking-[0.25em]">
                Enterprise Digital Presence Gateway
            </p>
        </div>

        <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-md px-4 sm:px-0">
            <div class="glass-morphism py-5 px-6 md:py-6 md:px-8 rounded-2xl md:rounded-[2rem] border border-slate-200/80 relative overflow-hidden">
                {{ $slot }}
            </div>

            <!-- Footer Links -->
            <div class="mt-4 text-center space-y-2">
                <p class="text-slate-500 text-[9px] font-semibold tracking-widest uppercase">
                    © 2026 • Advanced Analytics Division
                </p>
                <div class="flex items-center justify-center gap-6">
                    <a href="#"
                        class="text-[9px] font-black text-slate-500 hover:text-[#00ADC5] transition-colors uppercase tracking-widest">Privacy</a>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <a href="#"
                        class="text-[9px] font-black text-slate-500 hover:text-[#00ADC5] transition-colors uppercase tracking-widest">Support</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>