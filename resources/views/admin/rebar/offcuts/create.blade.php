<x-app-layout>
    <div class="py-6 space-y-6 max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                Register Manual Off-cut
            </h2>
            <a href="{{ route('admin.rebar.offcuts.index') }}"
                class="text-sm font-bold text-slate-500 hover:text-slate-800 transition-colors">
                &larr; Back to List
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden p-8">
            <div class="mb-6 p-4 bg-amber-50 rounded-xl border border-amber-100 flex gap-3">
                <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-600 shrink-0"></i>
                <p class="text-sm text-amber-800">
                    <strong>Note:</strong> Usually off-cuts are automatically generated when recording a <a
                        href="{{ route('admin.rebar.cutting-logs.create') }}"
                        class="underline font-bold hover:text-amber-900">Cutting Log</a>. Only use this form for initial
                    inventory setup or finding untracked pieces.
                </p>
            </div>

            <form action="{{ route('admin.rebar.offcuts.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Bar Diameter -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Bar
                            Diameter (mm) <span class="text-rose-500">*</span></label>
                        <select name="bar_diameter" required
                            class="w-full bg-white border-slate-200 rounded-xl focus:ring-[#D4AF37] focus:border-[#D4AF37]" style="background-color:#ffffff;">
                            <option value="" disabled selected>Select Diameter</option>
                            @foreach([8, 10, 12, 16, 20, 25, 32] as $d)
                                <option value="{{ $d }}" {{ old('bar_diameter') == $d ? 'selected' : '' }}>{{ $d }}mm</option>
                            @endforeach
                        </select>
                        @error('bar_diameter') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Length -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Length (mm)
                            <span class="text-rose-500">*</span></label>
                        <input type="number" name="length" value="{{ old('length') }}" required min="1"
                            class="w-full bg-white border-slate-200 rounded-xl focus:ring-[#D4AF37] focus:border-[#D4AF37]" style="background-color:#ffffff;">
                        @error('length') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Quantity
                            <span class="text-rose-500">*</span></label>
                        <input type="number" name="quantity" value="{{ old('quantity', 1) }}" required min="1"
                            class="w-full bg-white border-slate-200 rounded-xl focus:ring-[#D4AF37] focus:border-[#D4AF37]" style="background-color:#ffffff;">
                        @error('quantity') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Storage
                            Location</label>
                        <input type="text" name="storage_location" value="{{ old('storage_location') }}"
                            placeholder="e.g. Rack A-3"
                            class="w-full bg-white border-slate-200 rounded-xl focus:ring-[#D4AF37] focus:border-[#D4AF37]" style="background-color:#ffffff;">
                        @error('storage_location') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Status
                            <span class="text-rose-500">*</span></label>
                        <select name="status" required
                            class="w-full bg-white border-slate-200 rounded-xl focus:ring-[#D4AF37] focus:border-[#D4AF37]" style="background-color:#ffffff;">
                            <option value="Available" selected>Available</option>
                            <option value="Used">Used</option>
                            <option value="Scrap">Scrap</option>
                        </select>
                        @error('status') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Remarks -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Remarks</label>
                    <textarea name="remarks" rows="2"
                        class="w-full bg-white border-slate-200 rounded-xl focus:ring-[#D4AF37] focus:border-[#D4AF37]" style="background-color:#ffffff;">{{ old('remarks') }}</textarea>
                </div>

                <div class="flex items-center justify-end pt-4 border-t border-slate-100 gap-4">
                    <a href="{{ route('admin.rebar.offcuts.index') }}"
                        class="px-6 py-3 text-slate-600 font-bold hover:bg-white rounded-xl transition-all">Cancel</a>
                    <button type="submit"
                        class="px-6 py-3 bg-[#D4AF37] text-white rounded-xl font-bold shadow-lg shadow-cyan-500/20 hover:bg-[#0098ad] transition-all">
                        Register Off-cut
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>