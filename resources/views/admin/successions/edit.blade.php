<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.successions.index') }}" 
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#D4AF37] hover:border-[#D4AF37]/20 hover:bg-[#FFF8E7] transition-all">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Succession Nomination</h1>
                    <p class="text-slate-500 font-medium text-sm">Update evaluation for {{ $succession->candidate_name }}.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.successions.update', $succession) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- 1. Basic Information -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-[#D4AF37] text-white flex items-center justify-center text-xs">1</span>
                        Basic Information
                    </h2>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Candidate Name</label>
                        <input type="text" name="candidate_name" required value="{{ old('candidate_name', $succession->candidate_name) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all"
                               placeholder="Enter candidate name">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Department</label>
                        <select name="department" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all">
                            <option value="">Select Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}" {{ old('department', $succession->department) == $dept->name ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Line Manager</label>
                        <input type="text" name="line_manager" required value="{{ old('line_manager', $succession->line_manager) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all"
                               placeholder="Manager name">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Years in Current Position</label>
                        <input type="text" name="years_experience" required value="{{ old('years_experience', $succession->years_experience) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all"
                               placeholder="e.g. 5">
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Critical Role Targeted for Succession</label>
                        <input type="text" name="target_role" required value="{{ old('target_role', $succession->target_role) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all"
                               placeholder="Target position title">
                    </div>
                </div>
            </div>

            <!-- 2. Competencies Section -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-[#D4AF37] text-white flex items-center justify-center text-xs">2</span>
                        Competency Assessment
                    </h2>
                </div>
                <div class="p-8 space-y-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Core Competencies / Non-Technical</label>
                        <textarea name="core_competencies" required rows="3"
                                  placeholder="Leadership, Communication, Team Management, etc."
                                  class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all resize-none">{{ old('core_competencies', $succession->core_competencies) }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Technical Competencies</label>
                        <textarea name="technical_competencies" required rows="3"
                                  placeholder="Specific technical skills required for the target role"
                                  class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all resize-none">{{ old('technical_competencies', $succession->technical_competencies) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- 3. Performance & Justification -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-[#D4AF37] text-white flex items-center justify-center text-xs">3</span>
                        Performance & Justification
                    </h2>
                </div>
                <div class="p-8 space-y-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Justification for Nominated Candidate</label>
                        <textarea name="justification" required rows="3"
                                  placeholder="Why is this candidate being nominated?"
                                  class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all resize-none">{{ old('justification', $succession->justification) }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Key OKR Achievement</label>
                        <textarea name="okr_achievement" required rows="3"
                                  placeholder="Specific performance milestones and results"
                                  class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all resize-none">{{ old('okr_achievement', $succession->okr_achievement) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Readiness Level</label>
                            <select name="readiness_level" required
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all">
                                <option value="Ready Now" {{ old('readiness_level', $succession->readiness_level) == 'Ready Now' ? 'selected' : '' }}>Ready Now</option>
                                <option value="Within 1–2 Years" {{ old('readiness_level', $succession->readiness_level) == 'Within 1–2 Years' ? 'selected' : '' }}>Within 1–2 Years</option>
                                <option value="Within 3–5 Years" {{ old('readiness_level', $succession->readiness_level) == 'Within 3–5 Years' ? 'selected' : '' }}>Within 3–5 Years</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Latest IPG Score</label>
                            <input type="text" name="ipg_score" required value="{{ old('ipg_score', $succession->ipg_score) }}"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all"
                                   placeholder="e.g. Out of 100%">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Authorization -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-[#D4AF37] text-white flex items-center justify-center text-xs">4</span>
                        Signature
                    </h2>
                </div>
                <div class="p-8">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Update Signature (Optional)</label>
                        <div x-data="{ preview: '{{ $succession->signature_path ? \App\Support\StorageUrl::public($succession->signature_path) : null }}' }" class="space-y-4">
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
                            <div x-show="preview" class="p-4 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50 flex items-center justify-center">
                                <img :src="preview" class="max-h-40 rounded-xl shadow-sm border border-white" alt="Signature Preview">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pb-12">
                <a href="{{ route('admin.successions.index') }}" 
                   class="px-8 py-3 rounded-2xl font-bold text-slate-500 hover:bg-slate-100 transition-all">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-[#D4AF37] hover:bg-[#D4AF37]/90 text-white px-10 py-3 rounded-2xl font-bold transition-all shadow-lg shadow-[#D4AF37]/20 hover:scale-105 active:scale-95">
                    Update Nomination
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
