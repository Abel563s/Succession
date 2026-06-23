<x-app-layout>
    <div class="max-w-[1400px] mx-auto space-y-8 font-inter">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.transition.index') }}" 
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#111111] hover:border-[#111111]/20 transition-all">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Transition Plan</h1>
                    <p class="text-slate-500 font-medium text-sm">Update transition plans, replacement paths, and dates.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.transition.update', $transition) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-100 rounded-2xl p-6">
                    <div class="flex items-center gap-3 text-rose-600 mb-4">
                        <i data-lucide="alert-circle" class="w-5 h-5"></i>
                        <span class="text-[11px] font-black uppercase tracking-widest">Verification Errors</span>
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

            <!-- 1. Top Section: Department & Status -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Department</label>
                        <select name="department" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:border-[#111111] focus:ring-4 focus:ring-[#111111]/10 outline-none transition-all font-bold text-slate-700">
                            <option value="">Select Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}" {{ old('department', $transition->department) == $dept->name ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Transition Status</label>
                        <select name="status" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:border-[#111111] focus:ring-4 focus:ring-[#111111]/10 outline-none transition-all font-bold text-slate-700">
                            <option value="Planned" {{ old('status', $transition->status) == 'Planned' ? 'selected' : '' }}>Planned</option>
                            <option value="In Progress" {{ old('status', $transition->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Completed" {{ old('status', $transition->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Delayed" {{ old('status', $transition->status) == 'Delayed' ? 'selected' : '' }}>Delayed</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- 2. Transition Plan Grid/Table Section -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden" 
                 x-data="{ 
                     rows: @json($transition->items),
                     addRow() {
                         this.rows.push({ critical_role: '', current_holder: '', successor: '', transition_date: '' });
                     },
                     removeRow(index) {
                         if (this.rows.length > 1) {
                             this.rows.splice(index, 1);
                         }
                     }
                 }">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-[#111111] rounded-full"></span>
                        Transition Plan Details
                    </h3>
                    <button type="button" @click="addRow()" 
                            class="bg-[#111111] hover:bg-[#00333B] text-white px-4 py-2 rounded-xl font-bold text-xs flex items-center gap-1.5 transition-all shadow-sm">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Add Row
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-4 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center w-16">No.</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-left">Critical Role</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-left">Current Holder</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-left">Successor</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-left w-48">Transition Date</th>
                                <th class="px-4 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center w-16">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <template x-for="(row, index) in rows" :key="index">
                                <tr class="group hover:bg-slate-50/50 transition-all">
                                    <td class="px-4 py-4 text-center bg-slate-50/50 group-hover:bg-[#FFF8E7] transition-all">
                                        <span class="text-xs font-black text-[#111111]" x-text="index + 1"></span>
                                    </td>
                                    <td class="px-6 py-3">
                                        <input type="text" :name="'items['+index+'][critical_role]'" x-model="row.critical_role" required
                                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] outline-none text-xs font-bold text-slate-700">
                                    </td>
                                    <td class="px-6 py-3">
                                        <input type="text" :name="'items['+index+'][current_holder]'" x-model="row.current_holder" required
                                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] outline-none text-xs font-bold text-slate-700">
                                    </td>
                                    <td class="px-6 py-3">
                                        <input type="text" :name="'items['+index+'][successor]'" x-model="row.successor" required
                                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] outline-none text-xs font-bold text-slate-700">
                                    </td>
                                    <td class="px-6 py-3">
                                        <input type="date" :name="'items['+index+'][transition_date]'" x-model="row.transition_date" required
                                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] outline-none text-xs font-bold text-slate-700">
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <button type="button" @click="removeRow(index)" :disabled="rows.length === 1"
                                                class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 hover:text-rose-500 hover:bg-rose-50 flex items-center justify-center transition-all disabled:opacity-50">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. Signature Endorsement Section -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8 max-w-4xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Manager Signature -->
                    <div class="space-y-6">
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-[#111111] rounded-full"></span>
                            Manager's Signature
                        </h3>
                        
                        <div x-data="{ preview: '{{ $transition->signature_path ? \App\Support\StorageUrl::public($transition->signature_path) : '' }}' }">
                            <div class="relative group">
                                <input type="file" name="signature" accept="image/*"
                                       @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                                <div class="w-full px-6 py-8 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2rem] flex flex-col items-center justify-center gap-3 text-slate-400 group-hover:border-[#111111] group-hover:text-[#111111] transition-all">
                                    <i data-lucide="upload-cloud" class="w-8 h-8"></i>
                                    <span class="text-[10px] font-black uppercase tracking-[0.2em]">Upload New Manager Signature</span>
                                    <p class="text-[9px] font-bold opacity-50 uppercase">Leave blank to keep existing signature</p>
                                </div>
                            </div>
                            
                            <div x-show="preview" x-transition class="mt-6 p-4 border border-slate-100 rounded-3xl bg-slate-50 flex items-center justify-center">
                                <img :src="preview" class="max-h-32 rounded-xl shadow-lg border border-white" alt="Manager Signature Preview">
                            </div>
                        </div>
                    </div>

                    <!-- HR Signature -->
                    <div class="space-y-6">
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-[#6366F1] rounded-full"></span>
                            HR Signature
                        </h3>
                        
                        <div x-data="{ preview: '{{ $transition->hr_signature_path ? \App\Support\StorageUrl::public($transition->hr_signature_path) : '' }}' }">
                            <div class="relative group">
                                <input type="file" name="hr_signature" accept="image/*"
                                       @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                                <div class="w-full px-6 py-8 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2rem] flex flex-col items-center justify-center gap-3 text-slate-400 group-hover:border-[#6366F1] group-hover:text-[#6366F1] transition-all">
                                    <i data-lucide="upload-cloud" class="w-8 h-8"></i>
                                    <span class="text-[10px] font-black uppercase tracking-[0.2em]">Upload New HR Signature</span>
                                    <p class="text-[9px] font-bold opacity-50 uppercase">Leave blank to keep existing signature</p>
                                </div>
                            </div>
                            
                            <div x-show="preview" x-transition class="mt-6 p-4 border border-slate-100 rounded-3xl bg-slate-50 flex items-center justify-center">
                                <img :src="preview" class="max-h-32 rounded-xl shadow-lg border border-white" alt="HR Signature Preview">
                            </div>
                        </div>
                    </div>

                    <!-- DCEO Signature -->
                    <div class="space-y-6">
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-[#D4AF37] rounded-full"></span>
                            DCEO Signature
                        </h3>
                        
                        <div x-data="{ preview: '{{ $transition->dceo_signature_path ? \App\Support\StorageUrl::public($transition->dceo_signature_path) : '' }}' }">
                            <div class="relative group">
                                <input type="file" name="dceo_signature" accept="image/*"
                                       @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                                <div class="w-full px-6 py-8 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2rem] flex flex-col items-center justify-center gap-3 text-slate-400 group-hover:border-[#D4AF37] group-hover:text-[#D4AF37] transition-all">
                                    <i data-lucide="upload-cloud" class="w-8 h-8"></i>
                                    <span class="text-[10px] font-black uppercase tracking-[0.2em]">Upload New DCEO Signature</span>
                                    <p class="text-[9px] font-bold opacity-50 uppercase">Leave blank to keep existing signature</p>
                                </div>
                            </div>
                            
                            @if(!$transition->dceo_signature_path && auth()->user()->isDceo() && auth()->user()->signature_path)
                                <!-- Existing Signature Preview -->
                                <div class="mt-4 p-4 border border-emerald-200 bg-emerald-50 rounded-xl flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
                                        <span class="text-sm font-bold text-emerald-700">Your profile signature will be used. You can upload a new one to override it.</span>
                                    </div>
                                    <img src="{{ \App\Support\StorageUrl::public(auth()->user()->signature_path) }}" class="h-10 rounded border border-emerald-200" alt="Existing Signature">
                                </div>
                            @endif
                            
                            <div x-show="preview" x-transition class="mt-6 p-4 border border-slate-100 rounded-3xl bg-slate-50 flex items-center justify-center">
                                <img :src="preview" class="max-h-32 rounded-xl shadow-lg border border-white" alt="DCEO Signature Preview">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Action Buttons -->
            <div class="flex flex-col items-center pb-20">
                <div class="flex flex-wrap gap-4 justify-center">
                    <button type="submit" 
                            class="px-12 py-4 bg-slate-900 text-white rounded-[2rem] font-black uppercase tracking-[0.3em] text-[11px] shadow-2xl shadow-slate-900/40 hover:bg-[#111111] transition-all duration-500 active:scale-[0.98]">
                        UPDATE PLAN
                    </button>
                    <a href="{{ route('admin.transition.index') }}" 
                       class="px-12 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-[2rem] font-black uppercase tracking-[0.3em] text-[11px] transition-all">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
