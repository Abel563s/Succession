<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.leadership.index') }}" 
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#00ADC5] hover:border-[#00ADC5]/20 transition-all">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Edit Leadership Assessment</h1>
                    <p class="text-slate-500 font-medium text-sm">Updating leadership evaluation for {{ $leadership->candidate_name }}.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.leadership.update', $leadership) }}" method="POST" enctype="multipart/form-data" class="space-y-6 pb-12">
            @csrf
            @method('PUT')

            <!-- Section 1: Basic Info -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Candidate Name</label>
                        <input type="text" name="candidate_name" required value="{{ old('candidate_name', $leadership->candidate_name) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#00ADC5] outline-none transition-all font-bold text-slate-700"
                               placeholder="Full Name">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Department</label>
                        <select name="department" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#00ADC5] outline-none transition-all font-bold text-slate-700">
                            <option value="">Select Dept</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}" {{ old('department', $leadership->department) == $dept->name ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Line Manager</label>
                        <input type="text" name="line_manager" required value="{{ old('line_manager', $leadership->line_manager) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#00ADC5] outline-none transition-all font-bold text-slate-700"
                               placeholder="Manager's Name">
                    </div>
                </div>
            </div>

            <!-- Instructional Section -->
            <div class="bg-[#f0fbfd] border border-[#00ADC5]/10 rounded-[2rem] p-8 flex items-center gap-6">
                <div class="w-14 h-14 rounded-2xl bg-[#00ADC5] flex items-center justify-center text-white shrink-0 shadow-lg shadow-[#00ADC5]/20">
                    <i data-lucide="info" class="w-7 h-7"></i>
                </div>
                <div>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight">Assessment Instructions</h3>
                    <p class="text-slate-600 font-medium text-sm leading-relaxed">
                        Please rate the employee’s proficiency in the following leadership competencies on a scale of 1 to 5, where 1 is the lowest and 5 is the highest.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Assessment Table -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                            <h2 class="text-lg font-black text-slate-800 flex items-center gap-2 uppercase tracking-tight">
                                <i data-lucide="award" class="w-5 h-5 text-[#00ADC5]"></i>
                                Leadership Competencies
                            </h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                        <th class="px-8 py-4 text-center w-16">No.</th>
                                        <th class="px-4 py-4 text-left">Competency</th>
                                        <th class="px-8 py-4 text-center w-64">Proficiency Rating</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach($competencies as $index => $competency)
                                        @php 
                                            $existingRating = $leadership->ratings->firstWhere('competency_name', $competency);
                                            $ratingValue = $existingRating ? $existingRating->rating : 'null';
                                            $initialValue = old("ratings.$competency", $ratingValue);
                                        @endphp
                                        <tr class="hover:bg-slate-50/50 transition-colors" x-data="{ selected: {{ $initialValue }} }">
                                            <td class="px-8 py-6 text-center text-xs font-black text-slate-400">{{ $index + 1 }}</td>
                                            <td class="px-4 py-6">
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-black text-slate-800">{{ $competency }}</span>
                                                    <span class="text-[10px] font-medium text-slate-400 mt-0.5">Rating required (1-5)</span>
                                                </div>
                                            </td>
                                            <td class="px-8 py-6">
                                                <div class="flex items-center justify-between gap-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @php $id = Str::slug($competency) . '-' . $i; @endphp
                                                        <div class="flex-1">
                                                            <input type="radio" id="{{ $id }}" name="ratings[{{ $competency }}]" value="{{ $i }}" required 
                                                                   x-model="selected" class="sr-only">
                                                            <label for="{{ $id }}" 
                                                                   :class="selected == {{ $i }} ? 'bg-[#00ADC5] text-white border-[#00ADC5] shadow-lg shadow-[#00ADC5]/20' : 'bg-slate-50 text-slate-400 border-slate-200'"
                                                                   class="h-10 flex items-center justify-center rounded-xl text-xs font-black cursor-pointer transition-all border hover:border-[#00ADC5]/30">
                                                                {{ $i }}
                                                            </label>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Feedback & Signature -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden h-fit">
                        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                            <h2 class="text-lg font-black text-slate-800 flex items-center gap-2 uppercase tracking-tight">
                                <i data-lucide="message-square" class="w-5 h-5 text-[#00ADC5]"></i>
                                Comments & Feedback
                            </h2>
                        </div>
                        <div class="p-8 space-y-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Leadership Observations</label>
                                <textarea name="comments" rows="12" class="w-full px-6 py-4 bg-slate-50 border border-slate-200 focus:border-[#00ADC5] outline-none transition-all text-sm font-medium resize-none shadow-sm" placeholder="Detailed feedback on growth, performance, and recommendations...">{{ old('comments', $leadership->comments) }}</textarea>
                            </div>

                            <div class="space-y-4 pt-6 border-t border-slate-100">
                                <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Update Validation Signature</label>
                                <div x-data="{ preview: '{{ $leadership->signature_path ? asset('storage/' . $leadership->signature_path) : null }}' }" class="space-y-4">
                                    <input type="file" name="signature" accept="image/*"
                                           @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }"
                                           class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-slate-900 file:text-white cursor-pointer">
                                    <div x-show="preview" class="p-4 border border-dashed border-slate-200 rounded-2xl bg-slate-50 flex items-center justify-center h-32">
                                        <img :src="preview" class="max-h-24 rounded-lg shadow-sm" alt="Signature Preview">
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3 pt-6 border-t border-slate-100">
                                <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Assessment Status</label>
                                <select name="status" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#00ADC5] outline-none transition-all font-bold text-slate-700 rounded-xl">
                                    <option value="draft" {{ old('status', $leadership->status) == 'draft' ? 'selected' : '' }}>Save as Draft</option>
                                    <option value="published" {{ old('status', $leadership->status) == 'published' ? 'selected' : '' }}>Finalize & Publish</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col items-center pt-8 gap-4">
                <div class="flex items-center gap-4">
                    <button type="submit" 
                            class="bg-[#00ADC5] hover:bg-[#00ADC5]/90 text-white px-16 py-4 rounded-2xl font-black uppercase tracking-widest text-xs transition-all shadow-lg shadow-[#00ADC5]/20 hover:scale-105 active:scale-95">
                        UPDATE ASSESSMENT
                    </button>
                    <button type="reset" class="px-8 py-4 rounded-2xl bg-slate-100 text-slate-400 font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                        Reset
                    </button>
                </div>
                <a href="{{ route('admin.leadership.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-rose-500">Cancel & Return</a>
            </div>
        </form>
    </div>
</x-app-layout>
