<x-app-layout>
    <div class="max-w-[1400px] mx-auto space-y-8 font-inter">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.development.index') }}" 
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#00ADC5] hover:border-[#00ADC5]/20 transition-all">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Development Plan (IDP)</h1>
                    <p class="text-slate-500 font-medium text-sm">Update strategic growth roadmap for {{ $development->employee_name }}.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.development.update', $development) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- 1. Top Input Section (Employee Info) -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Employee Name</label>
                        <input type="text" name="employee_name" required value="{{ old('employee_name', $development->employee_name) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:border-[#00ADC5] focus:ring-4 focus:ring-[#00ADC5]/10 outline-none transition-all font-bold text-slate-700"
                               placeholder="Enter full name">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Department</label>
                        <select name="department" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:border-[#00ADC5] focus:ring-4 focus:ring-[#00ADC5]/10 outline-none transition-all font-bold text-slate-700">
                            <option value="">Select Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}" {{ old('department', $development->department) == $dept->name ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Line Manager</label>
                        <input type="text" name="line_manager" required value="{{ old('line_manager', $development->line_manager) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:border-[#00ADC5] focus:ring-4 focus:ring-[#00ADC5]/10 outline-none transition-all font-bold text-slate-700"
                               placeholder="Manager's Name">
                    </div>
                </div>
            </div>

            <!-- 2. IDP Table (Main Content) -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-4 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center w-16">No.</th>
                                <th class="px-4 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-left">Development Objectives</th>
                                <th class="px-4 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-left">Activities</th>
                                <th class="px-4 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-left">Resources</th>
                                <th class="px-4 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-left w-36">Timeline (Start)</th>
                                <th class="px-4 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-left w-36">Delivery Date</th>
                                <th class="px-4 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-left">Expected Outcome</th>
                                <th class="px-4 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center w-20">Score</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @for($i = 0; $i < max(5, $development->objectives->count()); $i++)
                                @php
                                    $obj = $development->objectives->get($i);
                                @endphp
                                <tr class="group hover:bg-slate-50/50 transition-all">
                                    <td class="px-4 py-4 text-center bg-slate-50/50 group-hover:bg-[#f0fbfd] transition-all">
                                        <span class="text-xs font-black text-[#00ADC5]">{{ $i + 1 }}</span>
                                    </td>
                                    <td class="px-2 py-2">
                                        <textarea name="objectives[{{ $i }}][objective]" rows="2" class="w-full bg-transparent border-0 focus:ring-0 text-xs font-medium placeholder-slate-300 resize-none p-2" placeholder="Describe objective...">{{ old("objectives.$i.objective", $obj->objective ?? '') }}</textarea>
                                    </td>
                                    <td class="px-2 py-2">
                                        <textarea name="objectives[{{ $i }}][activity]" rows="2" class="w-full bg-transparent border-0 focus:ring-0 text-xs font-medium placeholder-slate-300 resize-none p-2" placeholder="Specific activities...">{{ old("objectives.$i.activity", $obj->activity ?? '') }}</textarea>
                                    </td>
                                    <td class="px-2 py-2">
                                        <textarea name="objectives[{{ $i }}][resource]" rows="2" class="w-full bg-transparent border-0 focus:ring-0 text-xs font-medium placeholder-slate-300 resize-none p-2" placeholder="Needed resources...">{{ old("objectives.$i.resource", $obj->resource ?? '') }}</textarea>
                                    </td>
                                    <td class="px-2 py-2">
                                        <input type="date" name="objectives[{{ $i }}][start_date]" value="{{ old("objectives.$i.start_date", $obj->start_date ?? '') }}" class="w-full bg-transparent border-0 focus:ring-0 text-[11px] font-bold text-slate-600 p-2">
                                    </td>
                                    <td class="px-2 py-2">
                                        <input type="date" name="objectives[{{ $i }}][delivery_date]" value="{{ old("objectives.$i.delivery_date", $obj->delivery_date ?? '') }}" class="w-full bg-transparent border-0 focus:ring-0 text-[11px] font-bold text-slate-600 p-2">
                                    </td>
                                    <td class="px-2 py-2">
                                        <textarea name="objectives[{{ $i }}][expected_outcome]" rows="2" class="w-full bg-transparent border-0 focus:ring-0 text-xs font-medium placeholder-slate-300 resize-none p-2" placeholder="Anticipated results...">{{ old("objectives.$i.expected_outcome", $obj->expected_outcome ?? '') }}</textarea>
                                    </td>
                                    <td class="px-2 py-2">
                                        <input type="text" name="objectives[{{ $i }}][score]" value="{{ old("objectives.$i.score", $obj->score ?? '') }}" class="w-full bg-transparent border-0 focus:ring-0 text-xs font-black text-slate-900 text-center p-2" placeholder="0">
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. Signature Section -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8 max-w-2xl mx-auto">
                <div class="space-y-6">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-[#00ADC5] rounded-full"></span>
                        Authorization Endorsement
                    </h3>
                    
                    <div x-data="{ preview: '{{ $development->signature_path ? \App\Support\StorageUrl::public($development->signature_path) : null }}' }">
                        <div class="relative group">
                            <input type="file" name="signature" accept="image/*"
                                   @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                            <div class="w-full px-6 py-8 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2rem] flex flex-col items-center justify-center gap-3 text-slate-400 group-hover:border-[#00ADC5] group-hover:text-[#00ADC5] transition-all">
                                <i data-lucide="upload-cloud" class="w-8 h-8"></i>
                                <span class="text-[10px] font-black uppercase tracking-[0.2em]">Update Verification Signature (Optional)</span>
                                <p class="text-[9px] font-bold opacity-50 uppercase">Supports PNG, JPG (Max 2MB)</p>
                            </div>
                        </div>
                        
                        <div x-show="preview" x-transition class="mt-6 p-4 border border-slate-100 rounded-3xl bg-slate-50 flex items-center justify-center">
                            <img :src="preview" class="max-h-32 rounded-xl shadow-lg border border-white" alt="Signature Preview">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Submit Button -->
            <div class="flex flex-col items-center pb-20">
                <button type="submit" 
                        class="px-16 py-5 bg-slate-900 text-white rounded-[2rem] font-black uppercase tracking-[0.3em] text-[11px] shadow-2xl shadow-slate-900/40 hover:bg-[#00ADC5] transition-all duration-500 active:scale-[0.98]">
                    UPDATE IDP REPORT
                </button>
                <a href="{{ route('admin.development.index') }}" class="mt-4 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-rose-500 transition-colors">Cancel Evaluation</a>
            </div>
        </form>
    </div>
</x-app-layout>
