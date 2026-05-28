<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.critical-roles.index') }}" 
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#D4AF37] hover:border-[#D4AF37]/20 hover:bg-[#FFF8E7] transition-all">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Critical Role Evaluation</h1>
                    <p class="text-slate-500 font-medium text-sm">Update assessment for {{ $criticalRole->employee_name }}.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.critical-roles.update', $criticalRole) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information Card -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="user" class="w-5 h-5 text-[#D4AF37]"></i>
                        Basic Information
                    </h2>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Employee Name</label>
                        <input type="text" name="employee_name" required value="{{ old('employee_name', $criticalRole->employee_name) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all"
                               placeholder="e.g. John Doe">
                        @error('employee_name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Department</label>
                        <select name="department" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all">
                            <option value="">Select Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}" {{ old('department', $criticalRole->department) == $dept->name ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('department') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Critical Role / Position Title</label>
                        <input type="text" name="critical_role" required value="{{ old('critical_role', $criticalRole->critical_role) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all"
                               placeholder="e.g. Senior Project Manager">
                        @error('critical_role') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Position Assessment Card -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="activity" class="w-5 h-5 text-[#D4AF37]"></i>
                        Position Assessment
                    </h2>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Position Status</label>
                        <select name="position_status" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all">
                            <option value="Filled" {{ old('position_status', $criticalRole->position_status) == 'Filled' ? 'selected' : '' }}>Filled</option>
                            <option value="Vacant" {{ old('position_status', $criticalRole->position_status) == 'Vacant' ? 'selected' : '' }}>Vacant</option>
                        </select>
                        @error('position_status') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Vacancy Risk</label>
                        <select name="vacancy_risk" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all">
                            <option value="High" {{ old('vacancy_risk', $criticalRole->vacancy_risk) == 'High' ? 'selected' : '' }}>High</option>
                            <option value="Moderate" {{ old('vacancy_risk', $criticalRole->vacancy_risk) == 'Moderate' ? 'selected' : '' }}>Moderate</option>
                            <option value="Low" {{ old('vacancy_risk', $criticalRole->vacancy_risk) == 'Low' ? 'selected' : '' }}>Low</option>
                        </select>
                        @error('vacancy_risk') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Position Impact</label>
                        <select name="position_impact" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all">
                            <option value="High" {{ old('position_impact', $criticalRole->position_impact) == 'High' ? 'selected' : '' }}>High</option>
                            <option value="Moderate" {{ old('position_impact', $criticalRole->position_impact) == 'Moderate' ? 'selected' : '' }}>Moderate</option>
                            <option value="Low" {{ old('position_impact', $criticalRole->position_impact) == 'Low' ? 'selected' : '' }}>Low</option>
                        </select>
                        @error('position_impact') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Succession Planning Card -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="users" class="w-5 h-5 text-[#D4AF37]"></i>
                        Succession Planning
                    </h2>
                </div>
                <div class="p-8 space-y-8">
                    @for($i = 1; $i <= 3; $i++)
                        @php
                            $nameField = "successor_{$i}_name";
                            $readinessField = "successor_{$i}_readiness";
                        @endphp
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 rounded-2xl bg-slate-50 border border-slate-100 relative">
                            <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-6 h-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center font-black text-[#D4AF37] shadow-sm text-xs">
                                {{ $i }}
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Successor {{ $i }} Name</label>
                                <input type="text" name="{{ $nameField }}" value="{{ old($nameField, $criticalRole->$nameField) }}"
                                       class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all"
                                       placeholder="Full Name">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Readiness Level</label>
                                <select name="{{ $readinessField }}"
                                        class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all">
                                    <option value="">Select Readiness</option>
                                    <option value="Immediate" {{ old($readinessField, $criticalRole->$readinessField) == 'Immediate' ? 'selected' : '' }}>Immediate</option>
                                    <option value="1–2 Years" {{ old($readinessField, $criticalRole->$readinessField) == '1–2 Years' ? 'selected' : '' }}>1–2 Years</option>
                                    <option value="Long Term" {{ old($readinessField, $criticalRole->$readinessField) == 'Long Term' ? 'selected' : '' }}>Long Term</option>
                                </select>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Mitigation Plan & Signature -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-5 h-5 text-[#D4AF37]"></i>
                        Continuity & Manager's Signature
                    </h2>
                </div>
                <div class="p-8 space-y-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Mitigation Plan</label>
                        <textarea name="mitigation_plan" required rows="4"
                                  placeholder="Outline steps to reduce risk and ensure continuity in case of vacancy"
                                  class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all resize-none">{{ old('mitigation_plan', $criticalRole->mitigation_plan) }}</textarea>
                        @error('mitigation_plan') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Update Signature (Optional)</label>
                        <div x-data="{ preview: '{{ $criticalRole->signature_path ? \App\Support\StorageUrl::public($criticalRole->signature_path) : null }}' }" class="space-y-4">
                            <label class="block">
                                <span class="sr-only">Choose signature image</span>
                                <input type="file" name="signature" accept="image/*"
                                       @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }"
                                       class="block w-full text-sm text-slate-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-xl file:border-0
                                              file:text-sm file:font-black
                                              file:bg-[#FFF8E7] file:text-[#D4AF37]
                                              hover:file:bg-[#e6f7fa] transition-all cursor-pointer">
                            </label>
                            
                            <!-- Preview Area -->
                            <div x-show="preview" class="p-4 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50 flex items-center justify-center">
                                <img :src="preview" class="max-h-40 rounded-xl shadow-sm border border-white" alt="Signature Preview">
                            </div>
                        </div>
                        @error('signature') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pb-12">
                <a href="{{ route('admin.critical-roles.index') }}" 
                   class="px-8 py-3 rounded-2xl font-bold text-slate-500 hover:bg-slate-100 transition-all">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-[#D4AF37] hover:bg-[#D4AF37]/90 text-white px-10 py-3 rounded-2xl font-bold transition-all shadow-lg shadow-[#D4AF37]/20 hover:scale-105 active:scale-95">
                    Update Evaluation
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
