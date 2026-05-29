<x-guest-layout>
    <div class="space-y-4">
        <div>
            <p class="text-slate-400 font-semibold text-xs mt-0.5">Authenticate to access the management suite.</p>
        </div>

        <x-auth-session-status class="mb-2" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-3.5">
            @csrf

            <!-- Email Address -->
            <div class="space-y-1">
                <label for="email" class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">
                    Email
                </label>
                <div class="relative group">
                    <div
                        class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none transition-colors group-focus-within:text-[#00ADC5] text-slate-400">
                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                            </path>
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        autocomplete="username" placeholder="name@company.com"
                        class="block w-full pl-10 pr-4 py-2.5 bg-white/50 border-2 border-[#BEEAF0] rounded-xl text-xs text-slate-700 font-semibold placeholder-slate-300 focus:outline-none focus:ring-4 focus:ring-[#00ADC5]/15 focus:border-[#00ADC5] transition-all">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-0.5 text-[10px] font-bold text-rose-500 ml-1" />
            </div>

            <!-- Password -->
            <div class="space-y-1">
                <div class="flex items-center justify-between ml-1">
                    <label for="password" class="text-[9px] font-black text-slate-400 uppercase tracking-widest">
                        Password
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-[9px] font-black text-[#00ADC5] uppercase tracking-widest hover:text-[#083344] transition-colors">
                            Lost Key?
                        </a>
                    @endif
                </div>
                <div class="relative group">
                    <div
                        class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none transition-colors group-focus-within:text-[#00ADC5] text-slate-400">
                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        placeholder="••••••••"
                        class="block w-full pl-10 pr-4 py-2.5 bg-white/50 border-2 border-[#BEEAF0] rounded-xl text-xs text-slate-700 font-semibold placeholder-slate-300 focus:outline-none focus:ring-4 focus:ring-[#00ADC5]/15 focus:border-[#00ADC5] transition-all">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-0.5 text-[10px] font-bold text-rose-500 ml-1" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center ml-1">
                <input id="remember_me" type="checkbox" name="remember" value="1"
                    @checked(old('remember'))
                    class="w-4 h-4 shrink-0">
                <label for="remember_me"
                    class="ml-2.5 text-[10px] font-bold text-slate-400 cursor-pointer uppercase tracking-tight">Stay
                    authenticated on this device</label>
            </div>

            <!-- Security Challenge (Cloudflare Turnstile) -->
            <div class="pt-2 space-y-1.5">
                <div class="flex items-center justify-between px-1">
                    <div class="space-y-0.5">
                        <label class="text-[9px] font-black text-[#00ADC5] uppercase tracking-[0.2em] block">
                            Security Protocol
                        </label>
                        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-widest block">
                            Identity Verification Active
                        </span>
                    </div>
                    <div class="flex items-center gap-1.5 px-2 py-0.5 bg-slate-50 rounded border border-slate-100">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="text-[7.5px] font-black text-slate-400 uppercase tracking-widest">Secure</span>
                    </div>
                </div>

                <div class="relative group/turnstile">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-[#00ADC5]/20 to-[#083344]/20 rounded-2xl blur opacity-0 group-hover/turnstile:opacity-100 transition duration-1000">
                    </div>
                    <div
                        class="relative flex justify-center bg-white/40 backdrop-blur-md border-2 border-[#BEEAF0] p-2.5 rounded-2xl hover:border-[#00ADC5]/40 transition-all duration-500 shadow-md shadow-slate-200/50">
                        <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.key') }}"
                            data-theme="light"></div>
                    </div>
                </div>

                <x-input-error :messages="$errors->get('cf-turnstile-response')"
                    class="mt-1 text-[9px] font-black text-rose-500 ml-1 uppercase tracking-widest" />
            </div>

            <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

            <!-- Action -->
            <div class="pt-1">
                <button type="submit"
                    class="w-full bg-[#00ADC5] border-2 border-[#00ADC5] py-2.5 rounded-xl text-xs font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-[#083344]/15 hover:bg-[#083344] hover:border-[#083344] transition-all active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-[#00ADC5]/20">
                    Sign in
                </button>
            </div>

            <!-- Quick Access for Admin -->
            <div class="pt-1.5" x-data="{ 
                quickLogin() {
                    document.getElementById('email').value = 'admin@company.com';
                    document.getElementById('password').value = 'password123';
                }
            }">
                <button type="button" @click="quickLogin()"
                    class="w-full bg-[#F0FDFF] border-2 border-[#BEEAF0] py-2 rounded-xl text-[9px] font-black text-[#083344] uppercase tracking-[0.2em] hover:bg-white hover:border-[#00ADC5]/40 transition-all flex items-center justify-center gap-1.5">
                    <i data-lucide="shield-check" class="w-3 h-3"></i>
                    Auto-Fill Admin Credentials
                </button>
            </div>
        </form>

        <!-- Dynamic Hint -->
        <div class="pt-3 border-t border-slate-100 flex items-center gap-3">
            <div class="p-1.5 bg-cyan-50 rounded-lg">
                <svg class="w-3.5 h-3.5 text-[#00ADC5]" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <p class="text-[9px] font-bold text-slate-400 leading-relaxed uppercase tracking-tight">
                Use your official domain credentials to access your specific department dashboard.
            </p>
        </div>
    </div>
</x-guest-layout>