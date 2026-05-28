<x-app-layout>
    <div class="py-6 space-y-6 max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                Edit Off-cut <span class="text-slate-400">#{{ $offcut->offcut_code }}</span>
            </h2>
            <a href="{{ route('admin.rebar.offcuts.index') }}"
                class="text-sm font-bold text-slate-500 hover:text-slate-800 transition-colors">
                &larr; Back to List
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden p-8">
            <form action="{{ route('admin.rebar.offcuts.update', $offcut) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Read Only Info -->
                <div class="grid grid-cols-2 gap-6 bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <div>
                        <label
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Diameter</label>
                        <p class="font-black text-slate-800 text-lg">Ø{{ $offcut->bar_diameter }}mm</p>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Length</label>
                        <p class="font-black text-slate-800 text-lg">{{ $offcut->length }}mm</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Status -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Status
                            <span class="text-rose-500">*</span></label>
                        <select name="status" required
                            class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-[#D4AF37] focus:border-[#D4AF37]">
                            <option value="Available" {{ $offcut->status === 'Available' ? 'selected' : '' }}>Available
                            </option>
                            <option value="Used" {{ $offcut->status === 'Used' ? 'selected' : '' }}>Used</option>
                            <option value="Scrap" {{ $offcut->status === 'Scrap' ? 'selected' : '' }}>Scrap</option>
                        </select>
                        @error('status') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Storage
                            Location</label>
                        <input type="text" name="storage_location"
                            value="{{ old('storage_location', $offcut->storage_location) }}" placeholder="e.g. Rack A-3"
                            class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-[#D4AF37] focus:border-[#D4AF37]">
                        @error('storage_location') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Remarks -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Remarks</label>
                    <textarea name="remarks" rows="3"
                        class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-[#D4AF37] focus:border-[#D4AF37]">{{ old('remarks', $offcut->remarks) }}</textarea>
                </div>

                <div class="flex items-center justify-end pt-4 border-t border-slate-100 gap-4">
                    <a href="{{ route('admin.rebar.offcuts.index') }}"
                        class="px-6 py-3 text-slate-600 font-bold hover:bg-slate-50 rounded-xl transition-all">Cancel</a>
                    <button type="submit"
                        class="px-6 py-3 bg-[#D4AF37] text-white rounded-xl font-bold shadow-lg shadow-cyan-500/20 hover:bg-[#0098ad] transition-all">
                        Update Off-cut
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>