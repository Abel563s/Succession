<x-app-layout>
    <div class="py-6 space-y-6 max-w-4xl mx-auto" x-data="{ 
        requiredLength: {{ old('required_length', 0) }}, 
        quantity: {{ old('quantity', 0) }},
        totalLength() {
            return (this.requiredLength * this.quantity).toLocaleString();
        }
    }">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                    New Rebar Requirement
                </h2>
                <p class="text-sm text-slate-500 font-medium">Create and track structural steel requirements</p>
            </div>
            <a href="{{ route('admin.rebar.requirements.index') }}"
                class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-white transition-all shadow-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Back to List
            </a>
        </div>

        <div
            class="bg-white rounded-[2rem] shadow-xl shadow-slate-100 border border-slate-200/60 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-cyan-400 to-blue-500"></div>

            <form action="{{ route('admin.rebar.requirements.store') }}" method="POST" class="p-8 md:p-10 space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Structural Element -->
                    <div class="col-span-2 md:col-span-1">
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Structural
                            Element <span class="text-rose-500">*</span></label>
                        <select name="structural_element" required
                            class="w-full bg-white border-slate-200 rounded-2xl py-3.5 px-4 focus:ring-2 focus:ring-[#D4AF37]/10 focus:border-[#D4AF37] transition-all font-bold text-slate-700" style="background-color:#ffffff;">
                            <option value="" disabled selected>Select Element</option>
                            @foreach(['BIM', 'Slab', 'Columons', 'Shesr Wall', 'Footing', 'Retaining Wall'] as $elem)
                                <option value="{{ $elem }}" {{ old('structural_element') == $elem ? 'selected' : '' }}>
                                    {{ $elem }}
                                </option>
                            @endforeach
                        </select>
                        @error('structural_element') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bar Diameter -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Bar
                            Diameter <span class="text-rose-500">*</span></label>
                        <select name="bar_diameter" required
                            class="w-full bg-white border-slate-200 rounded-2xl py-3.5 px-4 focus:ring-2 focus:ring-[#D4AF37]/10 focus:border-[#D4AF37] transition-all font-bold text-slate-700" style="background-color:#ffffff;">
                            <option value="" disabled selected>Select Diameter</option>
                            @php
                                $diameters = [
                                    ['val' => 8, 'label' => 'Ø8mm'],
                                    ['val' => 10, 'label' => 'Ø10mm'],
                                    ['val' => 12, 'label' => 'Ø12mm'],
                                    ['val' => 14, 'label' => 'Ø14mm'],
                                    ['val' => 16, 'label' => 'Ø16mm'],
                                    ['val' => 18, 'label' => 'Ø18mm'],
                                    ['val' => 20, 'label' => 'Ø20mm'],
                                    ['val' => 24, 'label' => 'Ø24mm'],
                                    ['val' => 32, 'label' => 'Ø32mm'],
                                ];
                            @endphp
                            @foreach($diameters as $d)
                                <option value="{{ $d['val'] }}" {{ old('bar_diameter') == $d['val'] ? 'selected' : '' }}>
                                    {{ $d['label'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('bar_diameter') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Required Length -->
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Required
                            Length (mm) <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="required_length" x-model.number="requiredLength" required min="1"
                                placeholder="0"
                                class="w-full bg-white border-slate-200 rounded-2xl py-3.5 px-4 focus:ring-2 focus:ring-[#D4AF37]/10 focus:border-[#D4AF37] transition-all font-bold text-slate-700" style="background-color:#ffffff;">
                            <div
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase">
                                mm</div>
                        </div>
                        @error('required_length') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Quantity
                            <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="quantity" x-model.number="quantity" required min="1"
                                placeholder="0"
                                class="w-full bg-white border-slate-200 rounded-2xl py-3.5 px-4 focus:ring-2 focus:ring-[#D4AF37]/10 focus:border-[#D4AF37] transition-all font-bold text-slate-700" style="background-color:#ffffff;">
                            <div
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase">
                                PCS</div>
                        </div>
                        @error('quantity') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Total Length (Calculated) -->
                    <div class="col-span-2">
                        <div
                            class="bg-white border border-slate-100 rounded-2xl p-6 flex flex-col items-center justify-center text-center">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total
                                Length</span>
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl font-black text-amber-500" x-text="totalLength()">0</span>
                                <span class="text-sm font-black text-slate-400 uppercase">mm</span>
                            </div>
                            <p class="text-[9px] font-bold text-slate-400 mt-2 italic">(Required Length × Quantity)</p>
                        </div>
                    </div>

                    <!-- Drawing Reference -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Drawing
                            Reference</label>
                        <input type="text" name="drawing_reference" value="{{ old('drawing_reference') }}"
                            placeholder="e.g. ST-05 Rev.2"
                            class="w-full bg-white border-slate-200 rounded-2xl py-3.5 px-4 focus:ring-2 focus:ring-[#D4AF37]/10 focus:border-[#D4AF37] transition-all font-bold text-slate-700" style="background-color:#ffffff;">
                        @error('drawing_reference') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remarks -->
                    <div class="col-span-2 md:col-span-1">
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Remarks</label>
                        <input type="text" name="remarks" value="{{ old('remarks') }}"
                            placeholder="Optional additional notes"
                            class="w-full bg-white border-slate-200 rounded-2xl py-3.5 px-4 focus:ring-2 focus:ring-[#D4AF37]/10 focus:border-[#D4AF37] transition-all font-bold text-slate-700" style="background-color:#ffffff;">
                        @error('remarks') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end pt-8 border-t border-slate-100">
                    <button type="submit"
                        class="px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-cyan-500/20 hover:scale-[1.02] hover:shadow-cyan-500/30 transition-all active:scale-95">
                        Create Rebar Log
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>