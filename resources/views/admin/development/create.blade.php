<x-app-layout>
    <div class="max-w-[1400px] mx-auto space-y-8 font-inter">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.development.index') }}"
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#00ADC5] hover:border-[#00ADC5]/20 transition-all">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Individual Development Plan (IDP)</h1>
                    <p class="text-slate-500 font-medium text-sm">Plan development objectives. Scoring is completed in the linked Progress Review.</p>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-100 text-rose-700 px-6 py-4 rounded-2xl text-sm font-medium">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.development.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8"
              x-data="{ submitting: false }" @submit="submitting = true">
            @csrf

            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Employee Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="employee_name" required value="{{ old('employee_name') }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:border-[#00ADC5] outline-none font-bold text-slate-700">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Department <span class="text-rose-500">*</span></label>
                        <select name="department" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:border-[#00ADC5] outline-none font-bold text-slate-700">
                            <option value="">Select Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}" @selected(old('department') == $dept->name)>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Line Manager <span class="text-rose-500">*</span></label>
                        <input type="text" name="line_manager" required value="{{ old('line_manager', auth()->user()->name) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:border-[#00ADC5] outline-none font-bold text-slate-700">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-100 bg-slate-50/50">
                    <h2 class="text-sm font-black text-slate-900 uppercase tracking-widest">Development Objectives (All 5 Required)</h2>
                    <p class="text-xs text-slate-500 mt-1">Scores are entered later in the Progress Review linked to this plan.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-4 py-4 text-[10px] font-black uppercase text-slate-400 text-center w-16">No.</th>
                                <th class="px-4 py-4 text-[10px] font-black uppercase text-slate-400 text-left">Objectives *</th>
                                <th class="px-4 py-4 text-[10px] font-black uppercase text-slate-400 text-left">Activities *</th>
                                <th class="px-4 py-4 text-[10px] font-black uppercase text-slate-400 text-left">Resources *</th>
                                <th class="px-4 py-4 text-[10px] font-black uppercase text-slate-400 text-left w-36">Start *</th>
                                <th class="px-4 py-4 text-[10px] font-black uppercase text-slate-400 text-left w-36">Delivery *</th>
                                <th class="px-4 py-4 text-[10px] font-black uppercase text-slate-400 text-left">Expected Outcome *</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @for($i = 0; $i < 5; $i++)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-4 py-4 text-center font-black text-[#00ADC5]">{{ $i + 1 }}</td>
                                    <td class="px-2 py-2"><textarea name="objectives[{{ $i }}][objective]" rows="2" required class="w-full bg-slate-50 border border-slate-200 rounded-xl text-xs p-2">{{ old("objectives.{$i}.objective") }}</textarea></td>
                                    <td class="px-2 py-2"><textarea name="objectives[{{ $i }}][activity]" rows="2" required class="w-full bg-slate-50 border border-slate-200 rounded-xl text-xs p-2">{{ old("objectives.{$i}.activity") }}</textarea></td>
                                    <td class="px-2 py-2"><textarea name="objectives[{{ $i }}][resource]" rows="2" required class="w-full bg-slate-50 border border-slate-200 rounded-xl text-xs p-2">{{ old("objectives.{$i}.resource") }}</textarea></td>
                                    <td class="px-2 py-2"><input type="date" name="objectives[{{ $i }}][start_date]" required value="{{ old("objectives.{$i}.start_date") }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-xs p-2"></td>
                                    <td class="px-2 py-2"><input type="date" name="objectives[{{ $i }}][delivery_date]" required value="{{ old("objectives.{$i}.delivery_date") }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-xs p-2"></td>
                                    <td class="px-2 py-2"><textarea name="objectives[{{ $i }}][expected_outcome]" rows="2" required class="w-full bg-slate-50 border border-slate-200 rounded-xl text-xs p-2">{{ old("objectives.{$i}.expected_outcome") }}</textarea></td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8">
                    <x-hr-signature-field name="signature" label="Manager Signature *" :required="true" />
                </div>
                <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8">
                    <div x-data="{ preview: null }" class="space-y-4">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Candidate Signature *</label>
                        <input type="file" name="candidate_signature" accept="image/*" required
                               @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }"
                               class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-slate-900 file:text-white cursor-pointer">
                        <div x-show="preview" x-cloak class="p-4 border border-dashed border-slate-200 rounded-2xl bg-slate-50 flex justify-center">
                            <img :src="preview" class="max-h-28 rounded-xl" alt="Candidate signature preview">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col items-center pb-20">
                <button type="submit" :disabled="submitting"
                        class="px-16 py-5 bg-slate-900 text-white rounded-[2rem] font-black uppercase tracking-[0.3em] text-[11px] shadow-2xl disabled:opacity-50 disabled:cursor-not-allowed hover:bg-[#00ADC5] transition-all">
                    <span x-show="!submitting">CREATE IDP &amp; OPEN PROGRESS REVIEW</span>
                    <span x-show="submitting" x-cloak>Processing...</span>
                </button>
                <a href="{{ route('admin.development.index') }}" class="mt-4 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-rose-500">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
