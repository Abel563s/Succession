<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.coaching.index') }}" 
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#111111] hover:border-[#111111]/20 transition-all">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Employee Coaching Form</h1>
                    <p class="text-slate-500 font-medium text-sm">Professional coaching sessions for target development.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.coaching.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section 1: Basic Information -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="calendar" class="w-5 h-5 text-[#111111]"></i>
                        Session Logistics
                    </h2>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Candidate Name</label>
                        <input type="text" name="candidate_name" required value="{{ old('candidate_name') }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] focus:ring-4 focus:ring-[#111111]/10 outline-none transition-all font-bold text-slate-700"
                               placeholder="Full Name">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Supervisor / Coach</label>
                        <input type="text" name="supervisor" required value="{{ old('supervisor') }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] focus:ring-4 focus:ring-[#111111]/10 outline-none transition-all font-bold text-slate-700"
                               placeholder="Full Name">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Department</label>
                        <select name="department" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] focus:ring-4 focus:ring-[#111111]/10 outline-none transition-all font-bold text-slate-700">
                            <option value="">Select Dept</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Coaching Date</label>
                        <input type="date" name="coaching_date" required value="{{ old('coaching_date') }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] focus:ring-4 focus:ring-[#111111]/10 outline-none transition-all font-bold text-slate-700">
                    </div>
                </div>
            </div>

            <!-- Section 2: Coaching Topics -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="target" class="w-5 h-5 text-[#111111]"></i>
                        Core Focus Topics
                    </h2>
                </div>
                <div class="p-8 space-y-6">
                    @for($i = 1; $i <= 3; $i++)
                        <div class="space-y-2">
                            <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Topic Area {{ $i }}</label>
                            <textarea name="topic_{{ $i }}" required rows="2" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] focus:ring-4 focus:ring-[#111111]/10 outline-none transition-all text-sm font-medium resize-none shadow-sm" placeholder="Define focus topic..."></textarea>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Section 3: Development Details -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="trending-up" class="w-5 h-5 text-[#111111]"></i>
                        Strategic Roadmap
                    </h2>
                </div>
                <div class="p-8 space-y-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Desired Outcome</label>
                        <textarea name="desired_outcome" required rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] focus:ring-4 focus:ring-[#111111]/10 outline-none transition-all text-sm font-medium resize-none shadow-sm"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Benefits of Change</label>
                        <textarea name="benefits" required rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] focus:ring-4 focus:ring-[#111111]/10 outline-none transition-all text-sm font-medium resize-none shadow-sm"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Action Plan</label>
                        <textarea name="action_plan" required rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] focus:ring-4 focus:ring-[#111111]/10 outline-none transition-all text-sm font-medium resize-none shadow-sm"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Support from the Supervisor</label>
                        <textarea name="supervisor_support" required rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] focus:ring-4 focus:ring-[#111111]/10 outline-none transition-all text-sm font-medium resize-none shadow-sm"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Timeline</label>
                        <textarea name="timeline" required rows="2" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] focus:ring-4 focus:ring-[#111111]/10 outline-none transition-all text-sm font-medium resize-none shadow-sm"></textarea>
                    </div>
                </div>
            </div>

            <!-- Section 4: Signatures -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="check-square" class="w-5 h-5 text-[#111111]"></i>
                        Signatures
                    </h2>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Manager Signature</label>
                        <div x-data="{ preview: null }" class="space-y-4">
                            <label class="block">
                                <span class="sr-only">Choose signature image</span>
                                <input type="file" name="manager_sig" accept="image/*" {{ auth()->user()->signature_path ? '' : 'required' }}
                                       @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }"
                                       class="block w-full text-sm text-slate-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-xl file:border-0
                                              file:text-sm file:font-black
                                              file:bg-[#FFF8E7] file:text-[#D4AF37]
                                              hover:file:bg-[#e6f7fa] transition-all cursor-pointer">
                            </label>
                            @if(auth()->user()->signature_path)
                                <!-- Existing Signature Preview -->
                                <div class="mt-4 p-4 border border-emerald-200 bg-emerald-50 rounded-xl flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
                                        <span class="text-sm font-bold text-emerald-700">Signature on file will be used. You can upload a new one to override it.</span>
                                    </div>
                                    <img src="{{ \App\Support\StorageUrl::public(auth()->user()->signature_path) }}" class="h-10 rounded border border-emerald-200" alt="Existing Signature">
                                </div>
                            @endif
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
            <div class="flex flex-col items-center pb-12">
                <button type="submit" 
                        class="bg-gradient-to-r from-[#111111] to-[#00333B] hover:to-[#111111] text-white px-16 py-4 rounded-2xl font-black uppercase tracking-widest text-xs transition-all shadow-lg shadow-[#111111]/20 hover:scale-105 active:scale-95">
                    CREATE COACHING RECORD
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
