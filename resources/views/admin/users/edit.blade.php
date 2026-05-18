<x-app-layout>
    <div class="space-y-6">
        <!-- Modern Compact Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 pb-4 border-b border-slate-100">
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.users.index') }}"
                        class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-[#00ADC5] hover:border-[#00ADC5]/20 hover:rotate-[-10deg] transition-all shadow-sm">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>
                    <div>
                        <h2 class="text-3xl font-light text-slate-400 tracking-tight font-outfit leading-none">
                            Modify <span class="font-black text-slate-900">Identity</span>
                        </h2>
                        <p class="text-[10px] font-black text-[#00ADC5] uppercase tracking-[0.3em] mt-2">
                            {{ $user->name }} - Protocol Adjustment</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2 px-6 py-3 bg-white border border-slate-100 rounded-2xl shadow-sm">
                    <span
                        class="w-2 h-2 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-rose-500' }} animate-pulse"></span>
                    <span
                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ $user->is_active ? 'Identity Active' : 'Identity Locked' }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-8">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 p-10">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-10">
                        @csrf
                        @method('PUT')

                        <!-- Personal Data -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Protocol
                                    Identifier</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full rounded-2xl border-none bg-slate-50 p-4 font-bold text-slate-700 focus:ring-4 focus:ring-[#00ADC5]/10 transition-all text-sm">
                                <x-input-error :messages="$errors->get('name')" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Sync
                                    Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full rounded-2xl border-none bg-slate-50 p-4 font-bold text-slate-700 focus:ring-4 focus:ring-[#00ADC5]/10 transition-all text-sm">
                                <x-input-error :messages="$errors->get('email')" />
                            </div>
                        </div>

                        <!-- System Configuration -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Department Association</label>
                                <select name="department_id"
                                    class="w-full rounded-2xl border-none bg-slate-50 p-4 font-bold text-slate-700 focus:ring-4 focus:ring-[#00ADC5]/10 transition-all text-sm appearance-none cursor-pointer">
                                    <option value="">No Department Assigned</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ old('department_id', $user->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('department_id')" />
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Phone Protocol</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+1 (555) 000-0000"
                                    class="w-full rounded-2xl border-none bg-slate-50 p-4 font-bold text-slate-700 focus:ring-4 focus:ring-[#00ADC5]/10 transition-all text-sm">
                                <x-input-error :messages="$errors->get('phone')" />
                            </div>
                        </div>

                        <!-- Access Tier & Status -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Access
                                    Protocol (Role)</label>
                                <select name="role" required
                                    class="w-full rounded-2xl border-none bg-slate-50 p-4 font-bold text-slate-700 focus:ring-4 focus:ring-[#00ADC5]/10 transition-all text-sm appearance-none cursor-pointer">
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Manager
                                    </option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <x-input-error :messages="$errors->get('role')" />
                            </div>

                            <div class="space-y-2">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Protocol
                                    Status</label>
                                <select name="is_active" required
                                    class="w-full rounded-2xl border-none bg-slate-50 p-4 font-bold {{ $user->is_active ? 'text-emerald-600' : 'text-rose-600' }} focus:ring-4 focus:ring-[#00ADC5]/10 transition-all text-sm appearance-none cursor-pointer">
                                    <option value="1" {{ $user->is_active ? 'selected' : '' }}>🟢 Operational (Active)
                                    </option>
                                    <option value="0" {{ !$user->is_active ? 'selected' : '' }}>🔴 Decommissioned
                                        (Inactive)</option>
                                </select>
                                <x-input-error :messages="$errors->get('is_active')" />
                            </div>
                        </div>

                        <!-- Security Override -->
                        <div class="p-8 bg-amber-50 rounded-3xl border border-amber-100 space-y-6">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                                    <i data-lucide="shield-alert" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <h4
                                        class="text-xs font-black text-amber-900 uppercase tracking-widest leading-none">
                                        Access Key Override</h4>
                                    <p class="text-[10px] font-bold text-amber-600 mt-1 uppercase tracking-tight">Leave
                                        blank to maintain current secure credentials.</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-amber-700/60 uppercase tracking-widest ml-1">New
                                        Key</label>
                                    <input type="password" name="password" placeholder="••••••••"
                                        class="w-full rounded-xl border-none bg-white p-4 font-bold text-slate-700 focus:ring-4 focus:ring-amber-500/10 transition-all text-sm">
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-amber-700/60 uppercase tracking-widest ml-1">Confirm
                                        New Key</label>
                                    <input type="password" name="password_confirmation" placeholder="••••••••"
                                        class="w-full rounded-xl border-none bg-white p-4 font-bold text-slate-700 focus:ring-4 focus:ring-amber-500/10 transition-all text-sm">
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password')" />
                        </div>

                        <!-- Submit -->
                        <div class="flex items-center gap-4 pt-4 border-t border-slate-50">
                            <button type="submit"
                                class="px-10 py-4 bg-[#00ADC5] rounded-2xl text-xs font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-cyan-200 hover:bg-[#007A8A] transition-all active:scale-95">
                                Re-Synchronize Profile
                            </button>
                            <a href="{{ route('admin.users.index') }}"
                                class="px-8 py-4 bg-white border-2 border-slate-100 rounded-2xl text-xs font-black text-slate-400 uppercase tracking-[0.2em] hover:bg-slate-50 transition-all text-center">
                                Abort
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div
                class="lg:col-span-4 bg-slate-900 rounded-[2.5rem] p-10 text-white relative overflow-hidden shadow-2xl">
                <div class="relative z-10">
                    <h3 class="text-xs font-black text-white/30 uppercase tracking-[0.2em] mb-10">Security Protocol</h3>
                    <div class="space-y-8">
                        <div class="flex gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                                <i data-lucide="id-card" class="w-5 h-5 text-cyan-400"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-widest mb-1 italic text-cyan-400">
                                    Identify Node</h4>
                                <p class="text-xs text-white/60 font-medium leading-relaxed">Updating the primary sync
                                    email will require the user to sign in with the new credentials immediately.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                                <i data-lucide="key" class="w-5 h-5 text-[#00ADC5]"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-widest mb-1 italic text-[#00ADC5]">Key
                                    Override</h4>
                                <p class="text-xs text-white/60 font-medium leading-relaxed">Authority-level key resets
                                    bypass current session verification but trigger a core sync security alert.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Decor -->
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-[#00ADC5]/10 rounded-full blur-3xl"></div>
            </div>
        </div>
    </div>
</x-app-layout>