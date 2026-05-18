<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.mentor.index') }}" 
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#00ADC5] hover:border-[#00ADC5]/20 transition-all">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Mentor Feedback Form</h1>
                    <p class="text-slate-500 font-medium text-sm">Strategic mentorship tracking and performance review.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.mentor.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section 1: Basic Information -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="users" class="w-5 h-5 text-[#00ADC5]"></i>
                        Session Details
                    </h2>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Mentor Name</label>
                        <input type="text" name="mentor_name" required value="{{ old('mentor_name') }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#00ADC5] outline-none transition-all font-bold text-slate-700"
                               placeholder="Full Name">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Mentee Name</label>
                        <input type="text" name="mentee_name" required value="{{ old('mentee_name') }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#00ADC5] outline-none transition-all font-bold text-slate-700"
                               placeholder="Full Name">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Department</label>
                        <select name="department" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#00ADC5] outline-none transition-all font-bold text-slate-700">
                            <option value="">Select Dept</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Period Covered</label>
                        <input type="text" name="period_covered" value="{{ old('period_covered') }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#00ADC5] outline-none transition-all font-bold text-slate-700"
                               placeholder="e.g. Q1 2024">
                    </div>
                </div>
            </div>

            <!-- Section 2: Feedback Details -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="message-square" class="w-5 h-5 text-[#00ADC5]"></i>
                        Mentorship Feedback
                    </h2>
                </div>
                <div class="p-8 space-y-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Key Achievements by Mentee</label>
                        <textarea name="achievements" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#00ADC5] outline-none transition-all text-sm font-medium resize-none shadow-sm" placeholder="List key successes..."></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Areas for Improvement</label>
                        <textarea name="improvement_areas" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#00ADC5] outline-none transition-all text-sm font-medium resize-none shadow-sm" placeholder="What needs work..."></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Recommendations for Further Development</label>
                        <textarea name="recommendations" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#00ADC5] outline-none transition-all text-sm font-medium resize-none shadow-sm" placeholder="Next steps..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Section 3: Signature -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-8 space-y-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Mentor Signature</label>
                        <div x-data="{ preview: null }" class="space-y-4">
                            <input type="file" name="signature" accept="image/*" required
                                   @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }"
                                   class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-slate-900 file:text-white cursor-pointer">
                            <div x-show="preview" class="p-4 border border-dashed border-slate-200 rounded-2xl bg-slate-50 flex items-center justify-center">
                                <img :src="preview" class="max-h-24 rounded-lg shadow-sm" alt="Preview">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col items-center pb-12">
                <button type="submit" 
                        class="bg-[#00ADC5] hover:bg-[#00ADC5]/90 text-white px-16 py-4 rounded-2xl font-black uppercase tracking-widest text-xs transition-all shadow-lg shadow-[#00ADC5]/20 hover:scale-105 active:scale-95">
                    CREATE FEEDBACK RECORD
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
