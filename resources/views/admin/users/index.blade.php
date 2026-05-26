<x-app-layout>
    <div class="space-y-6 font-inter" x-data="{ 
        pwModal: false, 
        createModal: {{ $errors->any() && !session('pw_error') ? 'true' : 'false' }},
        selectedUser: {id: null, name: '', email: '', role: '', is_active: 1},
        openPwModal(user) {
            this.selectedUser = user;
            this.pwModal = true;
        }
    }">
        <!-- Modern Header Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-4 border-b border-slate-100 pb-4">
            <div class="flex flex-col text-left">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">User & Role Management</h1>
                <p class="text-xs text-slate-400 font-medium">Authority levels, department control, and permissions matrix.</p>
            </div>

            <!-- Perfectly Centered Badge -->
            <div class="hidden lg:flex items-center justify-center">
                <div class="flex items-center gap-3 px-4 py-2 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-xl hover:border-[#00515F]/20 transition-all duration-500 group/badge">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#00515F] transition-colors group-hover/badge:bg-[#00515F] group-hover/badge:text-white shadow-inner">
                        <i data-lucide="shield-check" class="w-5 h-5 transition-transform group-hover/badge:scale-110"></i>
                    </div>
                    <div class="flex flex-col text-left">
                        <div class="flex items-center gap-1.5">
                            <span class="text-2xl font-black text-slate-900 tracking-tighter leading-none">{{ $totalUsers }}</span>
                            <div class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></div>
                        </div>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest group-hover/badge:text-slate-600 transition-colors">Total Identity Nodes</span>
                    </div>
                </div>
            </div>

            @if(auth()->user()->isAdmin())
                <div class="flex md:justify-end">
                    <button @click="createModal = true"
                        class="bg-gradient-to-r from-[#00515F] to-[#00333B] hover:to-[#00515F] text-white px-5 py-2.5 rounded-xl font-bold text-sm flex items-center gap-2 transition-all duration-300 shadow-lg shadow-[#00515F]/20 hover:shadow-[#00515F]/30 hover:scale-[1.02] active:scale-95 group/btn relative overflow-hidden">
                        <div class="absolute inset-0 bg-white/10 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                        <i data-lucide="plus" class="w-4 h-4 relative z-10 transition-transform group-hover/btn:rotate-90"></i>
                        <span class="relative z-10">Add New User</span>
                    </button>
                </div>
            @endif
        </div>

        <!-- Compact Summary Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="bg-white px-4 py-3 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center text-slate-500 shrink-0">
                    <i data-lucide="users" class="w-4 h-4"></i>
                </div>
                <div class="text-left">
                    <div class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Total</div>
                    <div class="text-sm font-black text-slate-900 leading-tight">{{ $totalUsers }}</div>
                </div>
            </div>
            <div class="bg-white px-4 py-3 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0">
                    <i data-lucide="user-check" class="w-4 h-4"></i>
                </div>
                <div class="text-left">
                    <div class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Active</div>
                    <div class="text-sm font-black text-emerald-600 leading-tight">{{ $activeUsers }}</div>
                </div>
            </div>
            <div class="bg-white px-4 py-3 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0">
                    <i data-lucide="shield" class="w-4 h-4"></i>
                </div>
                <div class="text-left">
                    <div class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Admins</div>
                    <div class="text-sm font-black text-indigo-600 leading-tight">{{ $adminUsers }}</div>
                </div>
            </div>
            <div class="bg-white px-4 py-3 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-cyan-50 text-[#00ADC5] flex items-center justify-center shrink-0">
                    <i data-lucide="user" class="w-4 h-4"></i>
                </div>
                <div class="text-left">
                    <div class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Staff</div>
                    <div class="text-sm font-black text-[#00ADC5] leading-tight">{{ $deptUsers }}</div>
                </div>
            </div>
            <div class="bg-white px-4 py-3 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center shrink-0">
                    <i data-lucide="user-x" class="w-4 h-4"></i>
                </div>
                <div class="text-left">
                    <div class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Locked</div>
                    <div class="text-sm font-black text-rose-600 leading-tight">{{ $disabledUsers }}</div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="flex justify-center">
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm inline-block">
                <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap items-end justify-center gap-4">
                    <!-- Search Input -->
                    <div class="w-64 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Search</label>
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search candidate or email..."
                                class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] outline-none text-xs font-bold text-slate-700 transition-all">
                        </div>
                    </div>

                    <!-- Department Filter -->
                    <div class="w-48 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Department</label>
                        <select name="department_id" onchange="this.form.submit()"
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] outline-none text-xs font-bold text-slate-700 appearance-none cursor-pointer">
                            <option value="">All Departments</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Role Filter -->
                    <div class="w-40 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Role</label>
                        <select name="role" onchange="this.form.submit()"
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] outline-none text-xs font-bold text-slate-700 appearance-none cursor-pointer">
                            <option value="">All Roles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="dceo" {{ request('role') == 'dceo' ? 'selected' : '' }}>DCEO</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="w-40 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Status</label>
                        <select name="status" onchange="this.form.submit()"
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] outline-none text-xs font-bold text-slate-700 appearance-none cursor-pointer">
                            <option value="">All Statuses</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Locked</option>
                        </select>
                    </div>

                    <!-- Reset Button -->
                    <div class="flex items-center gap-2">
                        <button type="submit"
                            class="w-9 h-9 bg-[#00515F] text-white rounded-xl flex items-center justify-center hover:bg-[#00333B] transition-all shadow-sm shadow-[#00515F]/20 group/filter"
                            title="Apply Filters">
                            <i data-lucide="filter" class="w-4 h-4 transition-transform group-hover/filter:scale-110"></i>
                        </button>
                        @if(request()->anyFilled(['search', 'department_id', 'role', 'status']))
                            <a href="{{ route('admin.users.index') }}"
                                class="w-9 h-9 bg-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-rose-50 hover:text-rose-500 transition-all group/reset"
                                title="Reset Filters">
                                <i data-lucide="filter-x" class="w-4 h-4 transition-transform group-hover/reset:scale-110"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Identity Matrix Table -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#00515F] to-[#00333B] text-white text-[10px] font-black uppercase tracking-widest">
                            <th class="px-6 py-4 border-b border-white/5">Employee Profile</th>
                            <th class="px-6 py-4 border-b border-white/5 text-center">Employee ID</th>
                            <th class="px-6 py-4 border-b border-white/5 text-center">Department</th>
                            <th class="px-6 py-4 border-b border-white/5 text-center">Role / Privilege</th>
                            <th class="px-6 py-4 border-b border-white/5 text-center">System Status</th>
                            <th class="px-6 py-4 border-b border-white/5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50/50 transition-colors group text-sm">
                                 <td class="px-6 py-5">
                                     <div class="flex items-center gap-3 text-left">
                                         <div class="relative shrink-0">
                                             <div class="w-10 h-10 rounded-xl bg-[#f0fbfd] border border-[#00ADC5]/10 flex items-center justify-center font-black text-[#00ADC5] text-sm shadow-inner transition-transform group-hover:scale-110 duration-500">
                                                 {{ substr($user->name, 0, 1) }}
                                             </div>
                                             <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 rounded-full border-2 border-white {{ $user->is_active ? 'bg-emerald-500' : 'bg-slate-300' }}"></div>
                                         </div>
                                         <div>
                                             <p class="font-bold text-slate-900 leading-tight">{{ $user->name }}</p>
                                             <p class="text-xs text-slate-500 font-medium mt-0.5">{{ $user->email }}</p>
                                             @if($user->phone)
                                                 <p class="text-[9px] text-[#00ADC5] font-black uppercase tracking-wider mt-0.5">{{ $user->phone }}</p>
                                             @endif
                                             @if($user->role === 'manager')
                                                 <p class="text-[9px] font-black uppercase tracking-wider mt-1 {{ $user->signature_path ? 'text-emerald-600' : 'text-amber-600' }}">
                                                     {{ $user->signature_path ? 'Signature on file' : 'No signature uploaded' }}
                                                 </p>
                                             @endif
                                         </div>
                                     </div>
                                 </td>
                                 <td class="px-6 py-5 text-center">
                                     <span class="inline-flex px-2 py-1 rounded-lg bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-wider">
                                         {{ $user->employee_id ?? '---' }}
                                     </span>
                                 </td>
                                 <td class="px-6 py-5 text-center">
                                     <span class="inline-flex px-2 py-1 rounded-lg bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-tight">
                                         {{ $user->department ? $user->department->name : 'Unassigned' }}
                                     </span>
                                 </td>
                                 <td class="px-6 py-5 text-center">
                                     @php
                                         $roleStyles = match ($user->role) {
                                             'admin' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                             'manager' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                             'dceo' => 'bg-amber-50 text-amber-600 border-amber-100',
                                             default => 'bg-slate-50 text-slate-500 border-slate-100'
                                         };
                                     @endphp
                                     <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border {{ $roleStyles }}">
                                         {{ $user->role }}
                                     </span>
                                 </td>
                                 <td class="px-6 py-5 text-center">
                                     <form action="{{ route('admin.users.update', $user) }}" method="POST" class="inline">
                                         @csrf
                                         @method('PUT')
                                         <input type="hidden" name="name" value="{{ $user->name }}">
                                         <input type="hidden" name="email" value="{{ $user->email }}">
                                         <input type="hidden" name="role" value="{{ $user->role }}">
                                         <input type="hidden" name="is_active" value="{{ $user->is_active ? 0 : 1 }}">

                                         <button type="submit"
                                             class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border transition-all {{ $user->is_active ? 'bg-emerald-50 text-emerald-600 border-emerald-100 hover:bg-emerald-100/50' : 'bg-rose-50 text-rose-600 border-rose-100 hover:bg-rose-100/50' }}">
                                             {{ $user->is_active ? 'Active' : 'Locked' }}
                                         </button>
                                     </form>
                                 </td>
                                 <td class="px-6 py-5 text-right">
                                     <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                         <button
                                             @click="openPwModal({id: {{ $user->id }}, name: '{{ $user->name }}', email: '{{ $user->email }}', role: '{{ $user->role }}', is_active: {{ $user->is_active ? 1 : 0 }}})"
                                             class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 hover:text-amber-500 hover:bg-amber-50 flex items-center justify-center transition-all"
                                             title="Update Security Key">
                                             <i data-lucide="key-round" class="w-4 h-4"></i>
                                         </button>
                                         <a href="{{ route('admin.users.edit', $user) }}"
                                             class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 hover:text-indigo-500 hover:bg-indigo-50 flex items-center justify-center transition-all"
                                             title="Modify Node Details">
                                             <i data-lucide="user-cog" class="w-4 h-4"></i>
                                         </a>
                                         @if($user->id !== auth()->id() && auth()->user()->isAdmin())
                                             <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                 onsubmit="return confirm('Initiate user node decommission?')" class="inline">
                                                 @csrf
                                                 @method('DELETE')
                                                 <button type="submit"
                                                     class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 hover:text-rose-500 hover:bg-rose-50 flex items-center justify-center transition-all"
                                                     title="Decommission Node">
                                                     <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                 </button>
                                             </form>
                                         @endif
                                     </div>
                                     <p class="text-[10px] font-bold text-slate-300 mt-1 group-hover:hidden">{{ $user->created_at->format('M d, Y') }}</p>
                                 </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="w-16 h-16 rounded-3xl bg-slate-50 flex items-center justify-center text-slate-200">
                                            <i data-lucide="user-x" class="w-8 h-8"></i>
                                        </div>
                                        <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">No matching identity nodes detected.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

        <!-- Create New Identity Modal -->
        <div x-show="createModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-6"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-md" @click="createModal = false"></div>

            <!-- Modal Content -->
            <div class="relative bg-white rounded-[3rem] w-full max-w-2xl shadow-2xl border border-slate-100 p-1 md:p-1.5 overflow-hidden flex flex-col" style="max-height: 90vh;">
                <div class="bg-slate-50/50 rounded-[2.8rem] p-8 md:p-10 space-y-8 overflow-y-auto custom-scrollbar" style="max-height: calc(90vh - 8px);">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-[#00515F] text-white flex items-center justify-center shadow-xl shadow-[#00515F]/20 transform -rotate-3">
                                <i data-lucide="user-plus" class="w-7 h-7"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight font-outfit">Create New User</h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-0.5">Configure user detail</p>
                            </div>
                        </div>
                        <button @click="createModal = false"
                            class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-900 shadow-sm transition-all active:scale-95">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ role: '{{ old('role', 'user') }}' }">
                        @csrf
                        @if($errors->any() && !session('pw_error'))
                            <div class="p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-xl">
                                <div class="flex items-center gap-2 text-rose-700 font-bold text-sm mb-2">
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                    Please correct the following errors:
                                </div>
                                <ul class="list-disc pl-5 text-xs text-rose-600 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 text-left">
                            <!-- Name -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Full Legal Name</label>
                                <input type="text" name="name" required placeholder="Johnathan Doe"
                                    class="w-full px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 placeholder-slate-300 focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 transition-all outline-none">
                            </div>

                            <!-- Email -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Email</label>
                                <input type="email" name="email" required placeholder="name@company.com"
                                    class="w-full px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 placeholder-slate-300 focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 transition-all outline-none">
                            </div>

                            <!-- Department -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Department</label>
                                <select name="department_id"
                                    class="w-full px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 transition-all outline-none appearance-none cursor-pointer">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Phone -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Phone Number</label>
                                <input type="text" name="phone" placeholder="+1 (555) 000-0000"
                                    class="w-full px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 placeholder-slate-300 focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 transition-all outline-none">
                            </div>

                            <!-- Role -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Access Level</label>
                                <select name="role" required x-model="role"
                                    class="w-full px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 transition-all outline-none appearance-none cursor-pointer">
                                    <option value="user">Candidate</option>
                                    <option value="manager">Manager</option>
                                    <option value="dceo">DCEO</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>

                            <div class="space-y-4 md:col-span-2 p-6 bg-white border-2 border-[#00515F]/10 rounded-2xl" x-show="role === 'manager' || role === 'dceo'" x-cloak>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-[#f0fbfd] text-[#00515F] flex items-center justify-center">
                                        <i data-lucide="pen-line" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <label class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Signature Image <span class="text-rose-500">*</span></label>
                                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">Upload the signature now. It is saved on the profile and reused on HR forms.</p>
                                    </div>
                                </div>
                                <div x-data="{ preview: null, sizeError: null }" class="space-y-3">
                                    <input type="file" name="signature" accept="image/*"
                                           x-bind:required="role === 'manager' || role === 'dceo'"
                                           @change="
                                               sizeError = null;
                                               const file = $event.target.files[0];
                                               if (file) {
                                                   if (file.size > 512000) {
                                                       sizeError = 'File too large. Max size is 500KB.';
                                                       $event.target.value = '';
                                                       preview = null;
                                                   } else {
                                                       const reader = new FileReader();
                                                       reader.onload = (e) => preview = e.target.result;
                                                       reader.readAsDataURL(file);
                                                   }
                                               } else { preview = null; }"
                                           class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-[#00515F] file:text-white cursor-pointer">
                                    <div x-show="sizeError" class="flex items-center gap-1.5 mt-1">
                                        <i data-lucide="alert-circle" class="w-3 h-3 text-rose-500"></i>
                                        <p x-text="sizeError" class="text-[10px] font-bold text-rose-500"></p>
                                    </div>
                                    <p class="text-[10px] text-slate-400 font-medium">Max 500KB &bull; JPG, PNG, GIF</p>
                                    <div x-show="preview" x-cloak class="p-3 border border-dashed border-slate-200 rounded-2xl bg-slate-50 flex justify-center overflow-hidden">
                                        <img :src="preview" class="max-h-20 max-w-full object-contain rounded-xl shadow-sm border border-white" alt="Signature preview">
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Manage State</label>
                                <select name="is_active" required
                                    class="w-full px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 transition-all outline-none appearance-none cursor-pointer">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <!-- Password -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Security Key (Password)</label>
                                <input type="password" name="password" required placeholder="Minimum 8 characters"
                                    class="w-full px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 placeholder-slate-300 focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 transition-all outline-none">
                            </div>

                            <!-- Confirm Password -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Confirm Password</label>
                                <input type="password" name="password_confirmation" required placeholder="Re-enter security key"
                                    class="w-full px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 placeholder-slate-300 focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 transition-all outline-none">
                            </div>
                        </div>

                        <div class="pt-10 flex flex-col sm:flex-row gap-4">
                            <button type="button" @click="createModal = false"
                                class="flex-1 py-4 bg-slate-100 text-slate-500 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-slate-200 transition-all">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-[2] py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-2xl hover:bg-[#00515F] transition-all active:scale-95">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Password Update Modal -->
        <div x-show="pwModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-6"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-md" @click="pwModal = false"></div>

            <!-- Modal Content -->
            <div class="relative bg-white rounded-[3rem] w-full max-w-md shadow-2xl border border-slate-100 p-1 md:p-1.5 overflow-hidden">
                <div class="bg-slate-50/50 rounded-[2.8rem] p-8 md:p-10 space-y-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center shadow-xl shadow-amber-200">
                                <i data-lucide="key-round" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-900 tracking-tight font-outfit">Reset Key</h3>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-0.5">Security protocol update</p>
                            </div>
                        </div>
                        <button @click="pwModal = false" class="p-3 text-slate-400 hover:text-slate-900 transition-colors">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <form :action="`/admin/users/${selectedUser.id}`" method="POST" class="space-y-6 text-left">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="name" :value="selectedUser.name">
                        <input type="hidden" name="email" :value="selectedUser.email">
                        <input type="hidden" name="role" :value="selectedUser.role">
                        <input type="hidden" name="is_active" :value="selectedUser.is_active">

                        <div class="p-6 bg-white border border-slate-100 rounded-[1.5rem] shadow-sm">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Target Identity</p>
                            <p class="text-lg font-black text-slate-900 tracking-tight" x-text="selectedUser.name"></p>
                        </div>

                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">New Security Key</label>
                                <input type="password" name="password" required placeholder="••••••••"
                                    class="w-full px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 transition-all focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none">
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Confirm Identity Key</label>
                                <input type="password" name="password_confirmation" required placeholder="••••••••"
                                    class="w-full px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 transition-all focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none">
                            </div>
                        </div>

                        <div class="pt-4 flex gap-3">
                            <button type="button" @click="pwModal = false"
                                class="flex-1 py-4 bg-slate-100 text-slate-500 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-slate-200 transition-all">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-[2] py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-2xl hover:bg-amber-600 transition-all active:scale-95">
                                Update Security Node
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>