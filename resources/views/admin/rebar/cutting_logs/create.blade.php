<x-app-layout>
    <div class="py-6 space-y-8 max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Fabrication Entry</h2>
                <nav class="flex">
                    <ol class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                        <li>Cutting Log</li>
                        <li class="p-1 rounded-full bg-slate-100"><i data-lucide="chevron-right" class="w-2.5 h-2.5"></i></li>
                        <li class="text-amber-500">Record Activity</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.rebar.cutting-logs.index') }}"
                class="flex items-center gap-2 px-6 py-3 bg-slate-100 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Back to History
            </a>
        </div>

        <div class="bg-white rounded-[3rem] shadow-xl shadow-slate-200/50 border border-slate-200/60 overflow-hidden relative">
            <!-- Progress Accent -->
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-cyan-500 to-blue-600"></div>
            
            <form action="{{ route('admin.rebar.cutting-logs.store') }}" method="POST" class="p-10 md:p-14 space-y-10">
                @csrf

                <!-- Section: Reference -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-amber-50 flex items-center justify-center text-cyan-600">
                            <i data-lucide="link" class="w-4 h-4"></i>
                        </div>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Requirement Link</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Select Requirement <span class="text-rose-500">*</span></label>
                            <select name="rebar_requirement_id" id="requirement_id" required
                                class="w-full bg-slate-50 border-slate-100 rounded-2xl py-4 flex items-center font-bold text-slate-700 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 transition-all shadow-sm">
                                <option value="">-- Choose active requirement --</option>
                                @foreach($requirements as $req)
                                    <option value="{{ $req->id }}" 
                                        data-diameter="{{ $req->bar_diameter }}"
                                        data-length="{{ $req->required_length }}" 
                                        {{ (old('rebar_requirement_id') ?? request('requirement_id')) == $req->id ? 'selected' : '' }}>
                                        {{ $req->tracking_id }} | {{ $req->structural_element }} | Ø{{ $req->bar_diameter }}mm
                                    </option>
                                @endforeach
                            </select>
                            @error('rebar_requirement_id') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Section: Geometry -->
                <div class="space-y-6 pt-10 border-t border-slate-50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                            <i data-lucide="scissors" class="w-4 h-4"></i>
                        </div>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Cutting Parameters</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Production Date</label>
                            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required
                                class="w-full bg-slate-50 border-slate-100 rounded-2xl py-4 font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all shadow-sm">
                            @error('date') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Bar Diameter (Auto)</label>
                            <div class="relative">
                                <input type="number" name="bar_diameter" id="bar_diameter" value="{{ old('bar_diameter') }}" readonly required
                                    class="w-full bg-slate-100 border-transparent rounded-2xl py-4 font-bold text-slate-400 cursor-not-allowed">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase">mm</span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Source Bar Length</label>
                            <div class="relative">
                                <input type="number" name="original_length" id="original_length" value="{{ old('original_length', 12000) }}" required min="1"
                                    class="w-full bg-slate-50 border-slate-100 rounded-2xl py-4 font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all shadow-sm">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase">mm</span>
                            </div>
                        </div>

                        <div class="md:col-span-2 lg:col-span-1 space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Required Cut Length</label>
                            <div class="relative">
                                <input type="number" name="cut_length" id="cut_length" value="{{ old('cut_length') }}" required min="1"
                                    class="w-full bg-slate-50 border-slate-100 rounded-2xl py-4 font-bold text-slate-700 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all shadow-sm">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase">mm</span>
                            </div>
                        </div>

                        <!-- Remainder Card -->
                        <div class="md:col-span-2 lg:col-span-2 bg-slate-900 rounded-[2rem] p-8 flex items-center justify-between overflow-hidden relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-600/20 to-transparent opacity-0 group-hover:opacity-100 transition-all"></div>
                            <div class="relative z-10 flex items-center gap-6">
                                <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center text-cyan-400 backdrop-blur-sm border border-white/10">
                                    <i data-lucide="calculator" class="w-8 h-8"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-1">Generated Off-Cut</p>
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-4xl font-black text-white tracking-tighter" id="remainder_preview">0</span>
                                        <span class="text-xs font-black text-cyan-400 uppercase">mm</span>
                                    </div>
                                </div>
                            </div>
                            <div class="relative z-10 hidden md:block">
                                <div id="status_indicator" class="flex items-center gap-2 px-4 py-2 bg-emerald-500/10 rounded-full border border-emerald-500/20">
                                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                                    <span class="text-[9px] font-black text-emerald-400 uppercase tracking-widest">Valid Geometry</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Context -->
                <div class="space-y-6 pt-10 border-t border-slate-50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                            <i data-lucide="text-quote" class="w-4 h-4"></i>
                        </div>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Usage Context</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Usage / Location</label>
                            <input type="text" name="used_for" placeholder="e.g. Slab Beam B12, Floor 12" value="{{ old('used_for') }}"
                                class="w-full bg-slate-50 border-slate-100 rounded-2xl py-4 font-bold text-slate-700 focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all shadow-sm">
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Additional Remarks</label>
                            <input type="text" name="remarks" placeholder="Optional notes for fabrication team" value="{{ old('remarks') }}"
                                class="w-full bg-slate-50 border-slate-100 rounded-2xl py-4 font-bold text-slate-700 focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all shadow-sm">
                        </div>
                    </div>
                </div>

                <div class="pt-10 flex flex-col md:flex-row items-center gap-4 justify-between border-t border-slate-50">
                    <div class="flex items-center gap-3 text-slate-400">
                        <i data-lucide="info" class="w-4 h-4"></i>
                        <p class="text-[10px] font-bold uppercase tracking-widest">Off-cut will be automatically added to inventory</p>
                    </div>
                    <button type="submit"
                        class="w-full md:w-auto px-10 py-5 bg-gradient-to-r from-slate-900 to-slate-800 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] shadow-2xl shadow-slate-900/20 hover:scale-[1.02] hover:shadow-slate-900/30 transition-all active:scale-95 flex items-center justify-center gap-3">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Finalize & Record Cut
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const reqSelect = document.getElementById('requirement_id');
                const diameterInput = document.getElementById('bar_diameter');
                const cutLengthInput = document.getElementById('cut_length');
                const originalLengthInput = document.getElementById('original_length');
                const remainderPreview = document.getElementById('remainder_preview');
                const statusIndicator = document.getElementById('status_indicator');

                function updateDetails() {
                    const selectedOption = reqSelect.options[reqSelect.selectedIndex];
                    if (selectedOption.value) {
                        diameterInput.value = selectedOption.dataset.diameter;
                        cutLengthInput.value = selectedOption.dataset.length;
                    } else {
                        diameterInput.value = '';
                        cutLengthInput.value = '';
                    }
                    calculateRemainder();
                }

                function calculateRemainder() {
                    const original = parseInt(originalLengthInput.value) || 0;
                    const cut = parseInt(cutLengthInput.value) || 0;
                    const remainder = original - cut;

                    remainderPreview.innerText = remainder > 0 ? remainder : '0';

                    if (remainder < 0) {
                        statusIndicator.classList.remove('bg-emerald-500/10', 'border-emerald-500/20');
                        statusIndicator.classList.add('bg-rose-500/10', 'border-rose-500/20');
                        statusIndicator.innerHTML = `
                            <div class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></div>
                            <span class="text-[9px] font-black text-rose-400 uppercase tracking-widest">Invalid: Cut > Source</span>
                        `;
                        remainderPreview.classList.add('text-rose-400');
                    } else {
                        statusIndicator.classList.remove('bg-rose-500/10', 'border-rose-500/20');
                        statusIndicator.classList.add('bg-emerald-500/10', 'border-emerald-500/20');
                        statusIndicator.innerHTML = `
                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                            <span class="text-[9px] font-black text-emerald-400 uppercase tracking-widest">Valid Geometry</span>
                        `;
                        remainderPreview.classList.remove('text-rose-400');
                    }
                }

                reqSelect.addEventListener('change', updateDetails);
                originalLengthInput.addEventListener('input', calculateRemainder);
                cutLengthInput.addEventListener('input', calculateRemainder);

                // Init if pre-selected
                if (reqSelect.value) {
                    updateDetails();
                }
            });
        </script>
    @endpush
</x-app-layout>