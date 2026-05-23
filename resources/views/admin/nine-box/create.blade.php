<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.nine-box.index') }}" 
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#00ADC5] hover:border-[#00ADC5]/20 transition-all">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">9-Box Grid Evaluation</h1>
                    <p class="text-slate-500 font-medium text-sm">Talent potential vs performance mapping.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.nine-box.store') }}" method="POST" enctype="multipart/form-data" 
              x-data="{ 
                selected: null,
                potential: null,
                performance: null,
                grid: [
                    { name: 'Potential Gem', p: 'High', f: 'Low', color: 'bg-cyan-50', text: 'text-cyan-600' },
                    { name: 'High Potential', p: 'High', f: 'Medium', color: 'bg-blue-50', text: 'text-blue-600' },
                    { name: 'Star', p: 'High', f: 'High', color: 'bg-emerald-50', text: 'text-emerald-600' },
                    { name: 'Inconsistent Player', p: 'Medium', f: 'Low', color: 'bg-amber-50', text: 'text-amber-600' },
                    { name: 'Core Player', p: 'Medium', f: 'Medium', color: 'bg-indigo-50', text: 'text-indigo-600' },
                    { name: 'High Performer', p: 'Medium', f: 'High', color: 'bg-teal-50', text: 'text-teal-600' },
                    { name: 'Risk', p: 'Low', f: 'Low', color: 'bg-rose-50', text: 'text-rose-600' },
                    { name: 'Average Performer', p: 'Low', f: 'Medium', color: 'bg-slate-50', text: 'text-slate-600' },
                    { name: 'Solid Performer', p: 'Low', f: 'High', color: 'bg-slate-100', text: 'text-slate-800' }
                ],
                select(box) {
                    this.selected = box.name;
                    this.potential = box.p;
                    this.performance = box.f;
                }
              }" class="space-y-6">
            @csrf

            <!-- Hidden Data Inputs -->
            <input type="hidden" name="grid_position" x-model="selected">
            <input type="hidden" name="potential_level" x-model="potential">
            <input type="hidden" name="performance_level" x-model="performance">

            <!-- 1. Subject Details -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="user" class="w-5 h-5 text-[#00ADC5]"></i>
                        Candidate Information
                    </h2>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Candidate Name</label>
                        <input type="text" name="candidate_name" required value="{{ old('candidate_name') }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#00ADC5] focus:ring-4 focus:ring-[#00ADC5]/10 outline-none transition-all"
                               placeholder="Full Name">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Department</label>
                        <select name="department" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#00ADC5] focus:ring-4 focus:ring-[#00ADC5]/10 outline-none transition-all">
                            <option value="">Select Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- 2. The 9-Box Grid Matrix (Compact) -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="grid-3x3" class="w-5 h-5 text-[#00ADC5]"></i>
                        Talent Placement
                    </h2>
                </div>
                <div class="p-8">
                    <div class="flex gap-6">
                        <!-- Y-Axis Label -->
                        <div class="w-4 flex flex-col justify-between py-10 opacity-30">
                            <div class="flex flex-col justify-between h-full font-black text-[9px] text-slate-800">
                                <span>HI</span>
                                <span>MD</span>
                                <span>LO</span>
                            </div>
                        </div>
                        
                        <div class="flex-1 space-y-4">
                            <div class="grid grid-cols-3 gap-3">
                                <template x-for="box in grid">
                                    <div @click="select(box)"
                                         :class="selected === box.name ? box.color + ' border-[#00ADC5] ring-4 ring-[#00ADC5]/10 active-cell' : 'bg-slate-50 border-slate-100 hover:border-slate-300'"
                                         class="aspect-[4/3] border-2 rounded-2xl flex flex-col items-center justify-center text-center cursor-pointer transition-all p-3 group relative">
                                        <span class="text-[9px] font-black uppercase tracking-widest leading-tight" :class="selected === box.name ? box.text : 'text-slate-400 group-hover:text-slate-600'" x-text="box.name"></span>
                                    </div>
                                </template>
                            </div>
                            <!-- X-Axis Labels -->
                            <div class="grid grid-cols-3 gap-3">
                                <span class="text-[9px] font-black text-slate-300 text-center uppercase">Performance LO</span>
                                <span class="text-[9px] font-black text-slate-300 text-center uppercase">Performance MD</span>
                                <span class="text-[9px] font-black text-slate-300 text-center uppercase">Performance HI</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Evaluation Commentary -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="message-square" class="w-5 h-5 text-[#00ADC5]"></i>
                        Narrative Evaluation
                    </h2>
                </div>
                <div class="p-8 space-y-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">General Comments</label>
                        <textarea name="general_comments" required rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#00ADC5] outline-none transition-all resize-none text-sm font-medium"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Strengths</label>
                        <textarea name="strengths" required rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#00ADC5] outline-none transition-all resize-none text-sm font-medium"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Development Needs</label>
                        <textarea name="development_needs" required rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#00ADC5] outline-none transition-all resize-none text-sm font-medium"></textarea>
                    </div>
                </div>
            </div>

            <!-- 4. Authorization -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-5 h-5 text-[#00ADC5]"></i>
                        Signature
                    </h2>
                </div>
                <div class="p-8 space-y-6">
                    <div class="space-y-4">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Verification Signature</label>
                        <div x-data="{ preview: null }" class="space-y-4">
                            <input type="file" name="signature" accept="image/*" required
                                   @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }"
                                   class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-[#f0fbfd] file:text-[#00ADC5] cursor-pointer">
                            <div x-show="preview" class="p-4 border border-dashed border-slate-200 rounded-2xl bg-slate-50 flex items-center justify-center">
                                <img :src="preview" class="max-h-24 rounded-lg shadow-sm" alt="Preview">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-50">
                        <a href="{{ route('admin.nine-box.index') }}" class="px-6 py-3 text-sm font-bold text-slate-400 hover:text-slate-600 transition-all">Cancel</a>
                        <button type="submit" :disabled="!selected"
                                :class="selected ? 'bg-[#00ADC5] hover:scale-105 shadow-lg shadow-[#00ADC5]/20' : 'bg-slate-200 cursor-not-allowed'"
                                class="px-10 py-3 bg-[#00ADC5] text-white rounded-2xl font-black uppercase tracking-widest text-xs transition-all">
                            Submit Assessment
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
