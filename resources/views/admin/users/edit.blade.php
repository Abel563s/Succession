<x-app-layout>
    <div class="space-y-6">
        <!-- Modern Compact Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 pb-4 border-b border-slate-100">
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.users.index') }}"
                        class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-[#D4AF37] hover:border-[#D4AF37]/20 hover:rotate-[-10deg] transition-all shadow-sm">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>
                    <div>
                        <h2 class="text-3xl font-light text-slate-400 tracking-tight font-outfit leading-none">
                            Edit <span class="font-black text-slate-900">User</span>
                        </h2>
                        <p class="text-[10px] font-black text-[#D4AF37] uppercase tracking-[0.3em] mt-2">
                            {{ $user->name }} - Information Adjustment</p>
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
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" class="space-y-10" x-data="{ role: '{{ old('role', $user->role) }}' }">
                        @csrf
                        @method('PUT')

                        <!-- Personal Data -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">User Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full rounded-2xl border border-slate-200 bg-white p-4 font-bold text-slate-700 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 transition-all text-sm">
                                <x-input-error :messages="$errors->get('name')" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">
                                    Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full rounded-2xl border border-slate-200 bg-white p-4 font-bold text-slate-700 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 transition-all text-sm">
                                <x-input-error :messages="$errors->get('email')" />
                            </div>
                        </div>

                        <!-- System Configuration -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Department</label>
                                <select name="department_id"
                                    class="w-full rounded-2xl border border-slate-200 bg-white p-4 font-bold text-slate-700 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 transition-all text-sm appearance-none cursor-pointer">
                                    <option value="">No Department Assigned</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ old('department_id', $user->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('department_id')" />
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+1 (555) 000-0000"
                                    class="w-full rounded-2xl border border-slate-200 bg-white p-4 font-bold text-slate-700 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 transition-all text-sm">
                                <x-input-error :messages="$errors->get('phone')" />
                            </div>
                        </div>

                        <!-- Access Tier & Status -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Access
                                    Protocol (Role)</label>
                                <select name="role" required x-model="role"
                                    class="w-full rounded-2xl border border-slate-200 bg-white p-4 font-bold text-slate-700 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 transition-all text-sm appearance-none cursor-pointer">
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="dceo" {{ $user->role === 'dceo' ? 'selected' : '' }}>DCEO</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <x-input-error :messages="$errors->get('role')" />
                            </div>

                            <div class="space-y-2">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Activity
                                    Status</label>
                                <select name="is_active" required
                                    class="w-full rounded-2xl border border-slate-200 bg-white p-4 font-bold {{ $user->is_active ? 'text-emerald-600' : 'text-rose-600' }} focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 transition-all text-sm appearance-none cursor-pointer">
                                    <option value="1" {{ $user->is_active ? 'selected' : '' }}>🟢 Operational (Active)
                                    </option>
                                    <option value="0" {{ !$user->is_active ? 'selected' : '' }}>🔴 Decommissioned
                                        (Inactive)</option>
                                </select>
                                <x-input-error :messages="$errors->get('is_active')" />
                            </div>
                        </div>

                        <div class="p-8 bg-slate-50 rounded-3xl border border-slate-100 space-y-4" x-show="role === 'manager' || role === 'dceo'" x-cloak>
                            <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest">Manager Signature Image</h4>
                            <p class="text-[10px] text-slate-400 font-medium">Update the manager&apos;s signature image. This file is used when they sign HR forms.</p>
                            @if($user->signature_path)
                                <div class="flex flex-wrap items-center gap-4 p-4 bg-white rounded-2xl border border-slate-100">
                                    <x-storage-image :path="$user->signature_path" class="h-24 object-contain rounded-xl border border-slate-100 bg-white p-2" alt="Current manager signature" />
                                    <label class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 cursor-pointer">
                                        <input type="checkbox" name="remove_signature" value="1" class="rounded border-slate-300 text-rose-500">
                                        Remove current signature
                                    </label>
                                </div>
                            @endif
                            <div x-data="{ preview: null }" class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Upload new signature (optional)</label>
                                <input type="file" name="signature" accept="image/*"
                                       @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); } else { preview = null; }"
                                       class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-[#111111] file:text-white cursor-pointer">
                                <div x-show="preview" x-cloak class="p-4 border border-dashed border-slate-200 rounded-2xl bg-white flex justify-center">
                                    <img :src="preview" class="max-h-28 rounded-xl" alt="New signature preview">
                                </div>
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
                                        Change Current Password</h4>
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
                                class="px-10 py-4 bg-[#D4AF37] rounded-2xl text-xs font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-cyan-200 hover:bg-[#B8860B] transition-all active:scale-95">
                                Update Profile
                            </button>
                            <a href="{{ route('admin.users.index') }}"
                                class="px-8 py-4 bg-white border-2 border-slate-100 rounded-2xl text-xs font-black text-slate-400 uppercase tracking-[0.2em] hover:bg-slate-50 transition-all text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div
                class="lg:col-span-4 bg-slate-950 rounded-[2.5rem] p-10 text-white relative overflow-hidden shadow-2xl">
                <div class="relative z-10">
                    <h3 class="text-xs font-black text-slate-100 uppercase tracking-[0.2em] mb-10">Security Manual</h3>
                    <div class="space-y-8">
                        <div class="flex gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                                <i data-lucide="id-card" class="w-5 h-5 text-cyan-400"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-widest mb-1 italic text-cyan-400">
                                    System Identification</h4>
                                <p class="text-xs text-white/60 font-medium leading-relaxed">Updating the primary email will require the user to log in again using the new email credentials.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                                <i data-lucide="key" class="w-5 h-5 text-[#D4AF37]"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-widest mb-1 italic text-[#D4AF37]">System Access Override</h4>
                                <p class="text-xs text-white/60 font-medium leading-relaxed">Resetting a password key bypasses active session checks and sends a core security notification.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Decor -->
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-[#D4AF37]/10 rounded-full blur-3xl"></div>
            </div>
        </div>
    </div>
</x-app-layout>