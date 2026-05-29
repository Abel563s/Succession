<x-app-layout>
    <div class="py-10 px-6 space-y-8 max-w-4xl mx-auto font-inter animate-fade-in">

        <!-- Modern Compact Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 pb-4 border-b border-[#BEEAF0]">
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-[#083344] flex items-center justify-center text-[#00ADC5] shadow-xl shadow-[#083344]/20">
                        <i data-lucide="shield-lock" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-light text-slate-500 tracking-tight font-outfit leading-none">
                            Security <span class="font-black text-slate-900">Settings</span>
                        </h2>
                        <p class="text-[10px] font-black text-[#00ADC5] uppercase tracking-[0.3em] mt-2">Personal
                            Identity Authentication</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 px-6 py-3 bg-white border border-[#BEEAF0] rounded-2xl shadow-sm">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-[10px] font-black text-[#083344] uppercase tracking-widest">Active Session</span>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-center gap-3">
                <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600"></i>
                <span class="text-xs font-bold text-emerald-700">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Security Form -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="space-y-4">
                <div class="bg-white p-8 rounded-[2.5rem] border border-[#BEEAF0] shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-[#F0FDFF] flex items-center justify-center text-[#00ADC5] mb-6">
                        <i data-lucide="key" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-xl font-black text-[#083344] tracking-tight font-outfit">Identity Key</h3>
                    <p class="text-xs font-medium text-[#083344]/70 mt-2 leading-relaxed">
                        Update your authentication password regularly to maintain system integrity and node security.
                    </p>

                    <div class="mt-8 pt-6 border-t border-[#BEEAF0] space-y-3">
                        <div class="flex items-center gap-2">
                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-emerald-500"></i>
                            <span class="text-[10px] font-black text-[#083344]/70 uppercase tracking-widest">Min 8
                                Characters</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-emerald-500"></i>
                            <span class="text-[10px] font-black text-[#083344]/70 uppercase tracking-widest">Alphanumeric
                                Code</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2 space-y-6">
                @if ($errors->any())
                    <div class="bg-rose-50 border border-rose-100 rounded-2xl p-6">
                        <div class="flex items-center gap-3 text-rose-600 mb-4">
                            <i data-lucide="alert-circle" class="w-5 h-5"></i>
                            <span class="text-[11px] font-black uppercase tracking-widest">Authentication Errors</span>
                        </div>
                        <ul class="space-y-2">
                            @foreach ($errors->all() as $error)
                                <li class="text-xs font-bold text-rose-500 flex items-center gap-2">
                                    <span class="w-1 h-1 rounded-full bg-rose-400"></span>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-slate-100 group">
                    <form action="{{ route('admin.settings.password.update') }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Current Password -->
                            <div class="space-y-3">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Current
                                    Password</label>
                                <div class="relative">
                                    <i data-lucide="lock"
                                        class="w-4 h-4 absolute left-6 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                    <input type="password" name="current_password" required
                                        placeholder="Verify current password"
                                        class="w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-transparent focus:border-[#00ADC5] focus:bg-white rounded-2xl text-sm font-bold text-slate-700 transition-all outline-none">
                                </div>
                            </div>

                            <div class="h-px bg-slate-50"></div>

                            <!-- New Password -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">New
                                    Password</label>
                                <div class="relative">
                                    <i data-lucide="shield-check"
                                        class="w-4 h-4 absolute left-6 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                    <input type="password" name="password" required
                                        placeholder="Initialize new passphrase"
                                        class="w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-transparent focus:border-[#00ADC5] focus:bg-white rounded-2xl text-sm font-bold text-slate-700 transition-all outline-none">
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="space-y-3">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Confirm
                                    Password</label>
                                <div class="relative">
                                    <i data-lucide="refresh-cw"
                                        class="w-4 h-4 absolute left-6 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                    <input type="password" name="password_confirmation" required
                                        placeholder="Verify new password"
                                        class="w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-transparent focus:border-[#00ADC5] focus:bg-white rounded-2xl text-sm font-bold text-slate-700 transition-all outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit"
                                class="w-full group/btn relative px-8 py-4 bg-[#00ADC5] text-white rounded-[1.5rem] font-black text-[11px] uppercase tracking-widest overflow-hidden transition-all hover:scale-[1.02] active:scale-[0.98] shadow-2xl shadow-[#00ADC5]/20">
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-[#00ADC5] to-[#083344] translate-x-[-100%] group-hover/btn:translate-x-0 transition-transform duration-500">
                                </div>
                                <span class="relative flex items-center justify-center gap-3">
                                    <i data-lucide="save" class="w-4 h-4"></i>
                                    Update Password
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-[2rem] p-8 relative overflow-hidden border border-[#BEEAF0] group/alert shadow-sm">
                    <div
                        class="absolute -right-10 -top-10 w-40 h-40 bg-[#00ADC5] opacity-10 rounded-full blur-3xl group-hover/alert:opacity-20 transition-all duration-700">
                    </div>
                    <div class="flex items-start gap-4 relative z-10">
                        <div
                            class="w-10 h-10 rounded-xl bg-[#F0FDFF] flex items-center justify-center text-[#00ADC5] shrink-0">
                            <i data-lucide="info" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-[#00ADC5] uppercase tracking-widest">Security Note</p>
                            <p class="text-xs font-bold text-[#083344]/80 mt-1 leading-relaxed">
                                Updating your identity key will sign you out of all other active sessions immediately. Before continuing, make sure your connection is stable to avoid interruptions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>