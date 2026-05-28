<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.progress.index') }}" 
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#D4AF37] hover:border-[#D4AF37]/20 transition-all">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Progress Review Form</h1>
                    <p class="text-slate-500 font-medium text-sm">Strategic performance tracking and IDP milestones.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.progress.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6"
              x-data="{ submitting: false }" @submit="submitting = true">
            @csrf

            <!-- Section 1: Basic Information -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <i data-lucide="user" class="w-5 h-5 text-[#D4AF37]"></i>
                        Core Information
                    </h2>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Candidate Name</label>
                        <input type="text" name="candidate_name" required value="{{ old('candidate_name') }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] outline-none transition-all font-bold text-slate-700"
                               placeholder="Full Name">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Department</label>
                        <select name="department" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] outline-none transition-all font-bold text-slate-700">
                            <option value="">Select Dept</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Line Manager</label>
                        <input type="text" name="line_manager" required value="{{ old('line_manager') }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] outline-none transition-all font-bold text-slate-700"
                               placeholder="Manager's Name">
                    </div>
                </div>
            </div>

            <!-- Section 2: Performance Summary -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2 uppercase tracking-tight">
                        <i data-lucide="clipboard-list" class="w-5 h-5 text-[#D4AF37]"></i>
                        Performance Summary
                    </h2>
                </div>
                <div class="p-8 space-y-4">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Progress on IDP, Coaching & Training</label>
                        <textarea name="performance_summary" rows="5" class="w-full px-6 py-4 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] outline-none transition-all text-sm font-medium resize-none shadow-sm" placeholder="Summarize overall development progress..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Section 3: Progress Tracking -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden" x-data="{ rows: [0] }">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30 flex items-center justify-between">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2 uppercase tracking-tight">
                        <i data-lucide="activity" class="w-5 h-5 text-[#D4AF37]"></i>
                        Progress Tracking (IDP)
                    </h2>
                    <button type="button" @click="rows.push(rows.length)" class="text-xs font-black text-[#D4AF37] uppercase tracking-widest hover:text-[#008d9e] flex items-center gap-2 bg-[#FFF8E7] px-4 py-2 rounded-xl transition-all border border-[#D4AF37]/10">
                        <i data-lucide="plus" class="w-3 h-3"></i>
                        Add Row
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                <th class="px-8 py-4 text-left w-48">Review Date</th>
                                <th class="px-4 py-4 text-left">Key Achievements</th>
                                <th class="px-4 py-4 text-left">Challenges Faced</th>
                                <th class="px-4 py-4 text-left">Next Steps</th>
                                <th class="px-4 py-4 w-16"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(row, index) in rows" :key="index">
                                <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition-colors">
                                    <td class="px-8 py-4 align-top">
                                        <input type="date" name="review_date[]" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 outline-none focus:border-[#D4AF37] rounded-lg">
                                    </td>
                                    <td class="px-4 py-4">
                                        <textarea name="achievements[]" rows="2" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs font-medium text-slate-600 outline-none focus:border-[#D4AF37] rounded-lg resize-none shadow-sm"></textarea>
                                    </td>
                                    <td class="px-4 py-4">
                                        <textarea name="challenges[]" rows="2" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs font-medium text-slate-600 outline-none focus:border-[#D4AF37] rounded-lg resize-none shadow-sm"></textarea>
                                    </td>
                                    <td class="px-4 py-4">
                                        <textarea name="next_steps[]" rows="2" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs font-medium text-slate-600 outline-none focus:border-[#D4AF37] rounded-lg resize-none shadow-sm"></textarea>
                                    </td>
                                    <td class="px-4 py-4 text-center align-middle">
                                        <button type="button" @click="rows = rows.filter((_, i) => i !== index)" class="text-rose-400 hover:text-rose-600 transition-colors p-2 rounded-lg hover:bg-rose-50" x-show="rows.length > 1">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section 4: Skill Development -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2 uppercase tracking-tight">
                        <i data-lucide="graduation-cap" class="w-5 h-5 text-[#D4AF37]"></i>
                        Skill Development
                    </h2>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">New Competencies Acquired</label>
                        <textarea name="new_competencies" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] outline-none transition-all text-sm font-medium resize-none shadow-sm"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Gaps Identified</label>
                        <textarea name="gaps_identified" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] outline-none transition-all text-sm font-medium resize-none shadow-sm"></textarea>
                    </div>
                </div>
            </div>

            <!-- Section 5: Next Steps & Action Plan -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2 uppercase tracking-tight">
                        <i data-lucide="trending-up" class="w-5 h-5 text-[#D4AF37]"></i>
                        Next Steps & Action Plan
                    </h2>
                </div>
                <div class="p-8 space-y-4">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Updated Action Plan</label>
                        <textarea name="updated_action_plan" rows="5" class="w-full px-6 py-4 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] outline-none transition-all text-sm font-medium resize-none shadow-sm"></textarea>
                    </div>
                </div>
            </div>

            <!-- Section 6: Endorsement -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-8 flex flex-col md:flex-row md:items-center justify-between gap-8">
                    <div class="flex-1">
                        <x-hr-signature-field name="signature" label="Manager Signature *" :required="true" />
                    </div>
                    <div class="flex-shrink-0 space-y-3">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Status Tracking</label>
                        <select name="status" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] outline-none transition-all font-bold text-slate-700 rounded-xl">
                            <option value="draft">Draft Review</option>
                            <option value="completed">Completed Review</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col items-center pb-12 gap-4">
                <div class="flex items-center gap-4">
                    <button type="submit" :disabled="submitting"
                            class="bg-[#D4AF37] hover:bg-[#D4AF37]/90 text-white px-16 py-4 rounded-2xl font-black uppercase tracking-widest text-xs transition-all shadow-lg shadow-[#D4AF37]/20 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!submitting">CREATE PROGRESS REVIEW</span>
                        <span x-show="submitting" x-cloak>Processing...</span>
                    </button>
                    <button type="reset" class="px-8 py-4 rounded-2xl bg-slate-100 text-slate-400 font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                        Reset
                    </button>
                </div>
                <a href="{{ route('admin.progress.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-rose-500">Cancel & Return</a>
            </div>
        </form>
    </div>
</x-app-layout>
