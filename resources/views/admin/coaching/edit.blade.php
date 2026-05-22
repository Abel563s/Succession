<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.coaching.index') }}" 
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#00515F] hover:border-[#00515F]/20 transition-all">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Coaching Record</h1>
                    <p class="text-slate-500 font-medium text-sm">Update professional coaching session for {{ $coaching->candidate_name }}.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.coaching.update', $coaching) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Basic Information -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="calendar" class="w-5 h-5 text-[#00515F]"></i>
                        Session Logistics
                    </h2>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Candidate Name</label>
                        <input type="text" name="candidate_name" required value="{{ old('candidate_name', $coaching->candidate_name) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all font-bold text-slate-700"
                               placeholder="Full Name">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Supervisor / Coach</label>
                        <input type="text" name="supervisor" required value="{{ old('supervisor', $coaching->supervisor) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all font-bold text-slate-700"
                               placeholder="Full Name">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Department</label>
                        <select name="department" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all font-bold text-slate-700">
                            <option value="">Select Dept</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}" {{ old('department', $coaching->department) == $dept->name ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Coaching Date</label>
                        <input type="date" name="coaching_date" required value="{{ old('coaching_date', \Carbon\Carbon::parse($coaching->coaching_date)->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all font-bold text-slate-700">
                    </div>
                </div>
            </div>

            <!-- Section 2: Coaching Topics -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="target" class="w-5 h-5 text-[#00515F]"></i>
                        Core Focus Topics
                    </h2>
                </div>
                <div class="p-8 space-y-6">
                    @for($i = 1; $i <= 3; $i++)
                        @php $topicField = "topic_$i"; @endphp
                        <div class="space-y-2">
                            <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Topic Area {{ $i }}</label>
                            <textarea name="{{ $topicField }}" rows="2" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all text-sm font-medium resize-none shadow-sm" placeholder="Define focus topic...">{{ old($topicField, $coaching->$topicField) }}</textarea>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Section 3: Development Details -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="trending-up" class="w-5 h-5 text-[#00515F]"></i>
                        Strategic Roadmap
                    </h2>
                </div>
                <div class="p-8 space-y-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Desired Outcome</label>
                        <textarea name="desired_outcome" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all text-sm font-medium resize-none shadow-sm">{{ old('desired_outcome', $coaching->desired_outcome) }}</textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Benefits of Change</label>
                        <textarea name="benefits" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all text-sm font-medium resize-none shadow-sm">{{ old('benefits', $coaching->benefits) }}</textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Action Plan</label>
                        <textarea name="action_plan" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all text-sm font-medium resize-none shadow-sm">{{ old('action_plan', $coaching->action_plan) }}</textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Support from the Supervisor</label>
                        <textarea name="supervisor_support" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all text-sm font-medium resize-none shadow-sm">{{ old('supervisor_support', $coaching->supervisor_support) }}</textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Timeline</label>
                        <textarea name="timeline" rows="2" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/10 outline-none transition-all text-sm font-medium resize-none shadow-sm">{{ old('timeline', $coaching->timeline) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section 4: Signatures -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="check-square" class="w-5 h-5 text-[#00515F]"></i>
                        Endorsements (Optional Updates)
                    </h2>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Update Manager Signature</label>
                        <div x-data="{ preview: '{{ $coaching->manager_signature ? \App\Support\StorageUrl::public($coaching->manager_signature) : null }}' }" class="space-y-4">
                            <input type="file" name="manager_sig" accept="image/*"
                                   @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }"
                                   class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-slate-900 file:text-white cursor-pointer">
                            <div x-show="preview" class="p-4 border border-dashed border-slate-200 rounded-2xl bg-slate-50 flex items-center justify-center">
                                <img :src="preview" class="max-h-24 rounded-lg shadow-sm" alt="Manager Preview">
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Update Candidate Signature</label>
                        <div x-data="{ preview: '{{ $coaching->candidate_signature ? \App\Support\StorageUrl::public($coaching->candidate_signature) : null }}' }" class="space-y-4">
                            <input type="file" name="candidate_sig" accept="image/*"
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
                    UPDATE COACHING RECORD
                </button>
                <a href="{{ route('admin.coaching.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-rose-500">Cancel Update</a>
            </div>
        </form>
    </div>
</x-app-layout>
