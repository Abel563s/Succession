<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.training.index') }}" 
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#00515F] hover:border-[#00515F]/20 transition-all">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Training Program Form</h1>
                    <p class="text-slate-500 font-medium text-sm">Design structured learning goals and skill mastery.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.training.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section 1: Basic Information -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="info" class="w-5 h-5 text-[#00515F]"></i>
                        Basic Information
                    </h2>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Candidate Name</label>
                        <input type="text" name="candidate_name" required value="{{ old('candidate_name') }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all font-bold text-slate-700"
                               placeholder="Full Name">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Department</label>
                        <select name="department" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all font-bold text-slate-700">
                            <option value="">Select Dept</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Line Manager</label>
                        <input type="text" name="line_manager" required value="{{ old('line_manager') }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all font-bold text-slate-700"
                               placeholder="Manager's Name">
                    </div>
                </div>
            </div>

            <!-- Section 2: Goals & Training -->
            <div class="space-y-6">
                @for($i = 1; $i <= 3; $i++)
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden relative group">
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#00515F]/20 group-hover:bg-[#00515F] transition-all"></div>
                        <div class="p-8 space-y-6">
                            <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                                <div class="w-8 h-8 rounded-lg bg-[#f0fbfd] text-[#00515F] flex items-center justify-center font-black text-sm">
                                    {{ $i }}
                                </div>
                                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Goal {{ $i }} Architecture</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                                <div class="md:col-span-6 space-y-2">
                                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Goal {{ $i }} Description</label>
                                    <textarea name="goal_{{ $i }}" rows="2" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all text-sm font-medium resize-none shadow-sm" placeholder="Define the objective..."></textarea>
                                </div>
                                <div class="md:col-span-4 space-y-2">
                                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Skill / Training Area {{ $i }}</label>
                                    <input type="text" name="skill_area_{{ $i }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all text-sm font-bold text-slate-700 shadow-sm" placeholder="e.g. Leadership">
                                </div>
                                <div class="md:col-span-2 space-y-2">
                                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Score {{ $i }}</label>
                                    <input type="text" name="score_{{ $i }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all text-sm font-black text-slate-900 text-center shadow-sm" placeholder="0">
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- Section 3: Development Details -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="file-text" class="w-5 h-5 text-[#00515F]"></i>
                        Execution Strategy
                    </h2>
                </div>
                <div class="p-8 space-y-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Activities</label>
                        <p class="text-[10px] text-slate-400 font-medium ml-1 mb-2">Outline specific activities that will help achieve this goal</p>
                        <textarea name="activities" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all text-sm font-medium resize-none"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Expected Outcomes</label>
                        <p class="text-[10px] text-slate-400 font-medium ml-1 mb-2">Expected Outcomes with time frames</p>
                        <textarea name="expected_outcomes" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all text-sm font-medium resize-none"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Feedback and Evaluation</label>
                        <p class="text-[10px] text-slate-400 font-medium ml-1 mb-2">Feedback and Evaluation</p>
                        <textarea name="feedback" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all text-sm font-medium resize-none"></textarea>
                    </div>
                </div>
            </div>

            <!-- Section 4: Signatures -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="check-square" class="w-5 h-5 text-[#00515F]"></i>
                        Endorsements
                    </h2>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Manager Signature</label>
                        <div x-data="{ preview: null }" class="space-y-4">
                            <input type="file" name="manager_sig" accept="image/*" required
                                   @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }"
                                   class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-slate-900 file:text-white cursor-pointer">
                            <div x-show="preview" class="p-4 border border-dashed border-slate-200 rounded-2xl bg-slate-50 flex items-center justify-center">
                                <img :src="preview" class="max-h-24 rounded-lg shadow-sm" alt="Manager Preview">
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Candidate Signature</label>
                        <div x-data="{ preview: null }" class="space-y-4">
                            <input type="file" name="candidate_sig" accept="image/*" required
                                   @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }"
                                   class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-slate-900 file:text-white cursor-pointer">
                            <div x-show="preview" class="p-4 border border-dashed border-slate-200 rounded-2xl bg-slate-50 flex items-center justify-center">
                                <img :src="preview" class="max-h-24 rounded-lg shadow-sm" alt="Candidate Preview">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col items-center pb-12 gap-4">
                <button type="submit" 
                        class="bg-gradient-to-r from-[#00515F] to-[#00333B] hover:to-[#00515F] text-white px-16 py-4 rounded-2xl font-black uppercase tracking-widest text-xs transition-all shadow-lg shadow-[#00515F]/20 hover:scale-105 active:scale-95">
                    CREATE TRAINING RECORD
                </button>
                <a href="{{ route('admin.training.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-rose-500">Cancel Report</a>
            </div>
        </form>
    </div>
</x-app-layout>
