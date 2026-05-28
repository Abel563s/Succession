<x-app-layout>
    <div class="max-w-[95%] mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.sd.index') }}" 
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#D4AF37] hover:border-[#D4AF37]/20 transition-all">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Succession Dashboard</h1>
                    <p class="text-slate-500 font-medium text-sm">Update leadership development and succession tracking matrix for {{ $sd->title }}.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.sd.update', $sd) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Header Section: Basic Info -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Dashboard Title / Period</label>
                        <input type="text" name="title" required value="{{ old('title', $sd->title) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] outline-none transition-all font-bold text-slate-700"
                               placeholder="e.g., 2026 Executive Succession Plan">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Department Scope</label>
                        <select name="department" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] outline-none transition-all font-bold text-slate-700">
                            <option value="">All Departments</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}" {{ old('department', $sd->department) == $dept->name ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Main Table Section -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden" x-data="{ 
                rows: {{ json_encode($sd->items->map(fn($item) => [
                    'position' => $item->position,
                    'current_holder' => $item->current_holder,
                    'candidates' => $item->candidates,
                    'timeline_progress' => $item->timeline_progress,
                    'competency_progress' => $item->competency_progress,
                    'development_progress' => $item->development_progress,
                    'kpi_metrics' => $item->kpi_metrics,
                    'monitoring_progress' => $item->monitoring_progress,
                    'readiness_rating' => $item->readiness_rating
                ])) ?: '[]' }},
                readinessOptions: [
                    'Ready Now',
                    'Ready in 6 Months',
                    'Ready in 1 Year',
                    'Needs Development',
                    'High Potential'
                ]
            }">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30 flex items-center justify-between">
                    <h2 class="text-lg font-black text-slate-800 flex items-center gap-2 uppercase tracking-tight">
                        <i data-lucide="layers" class="w-5 h-5 text-[#D4AF37]"></i>
                        Succession Matrix
                    </h2>
                    <button type="button" @click="rows.push({position: '', current_holder: '', candidates: '', timeline_progress: '', competency_progress: '', development_progress: '', kpi_metrics: '', monitoring_progress: '', readiness_rating: 'Ready Now'})" class="text-xs font-black text-[#D4AF37] uppercase tracking-widest hover:text-[#008d9e] flex items-center gap-2 bg-[#FFF8E7] px-4 py-2 rounded-xl transition-all border border-[#D4AF37]/10">
                        <i data-lucide="plus" class="w-3 h-3"></i>
                        Add Succession Row
                    </button>
                </div>
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full border-collapse min-w-[1500px]">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                <th class="px-4 py-4 text-center w-12">No.</th>
                                <th class="px-4 py-4 text-left w-48">Position for Succession</th>
                                <th class="px-4 py-4 text-left w-48">Current Holder</th>
                                <th class="px-4 py-4 text-left w-48">Candidates</th>
                                <th class="px-4 py-4 text-left">Timeline & Progress</th>
                                <th class="px-4 py-4 text-left">Key Competencies</th>
                                <th class="px-4 py-4 text-left">Dev. Plan Progress</th>
                                <th class="px-4 py-4 text-left">KPI & Performance</th>
                                <th class="px-4 py-4 text-left">Monitoring</th>
                                <th class="px-4 py-4 text-left w-40">Readiness</th>
                                <th class="px-4 py-4 w-12"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(row, index) in rows" :key="index">
                                <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition-colors group">
                                    <td class="px-4 py-4 text-center text-xs font-bold text-slate-400" x-text="index + 1"></td>
                                    <td class="px-4 py-4">
                                        <input type="text" name="position[]" required x-model="row.position" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 outline-none focus:border-[#D4AF37] rounded-lg" placeholder="Position Name">
                                    </td>
                                    <td class="px-4 py-4">
                                        <input type="text" name="current_holder[]" required x-model="row.current_holder" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 outline-none focus:border-[#D4AF37] rounded-lg" placeholder="Current Employee">
                                    </td>
                                    <td class="px-4 py-4">
                                        <input type="text" name="candidates[]" required x-model="row.candidates" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 outline-none focus:border-[#D4AF37] rounded-lg" placeholder="Succession Candidates">
                                    </td>
                                    <td class="px-4 py-4">
                                        <textarea name="timeline_progress[]" x-model="row.timeline_progress" rows="2" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs font-medium text-slate-600 outline-none focus:border-[#D4AF37] rounded-lg resize-none shadow-sm" placeholder="Timeline details..."></textarea>
                                    </td>
                                    <td class="px-4 py-4">
                                        <textarea name="competency_progress[]" x-model="row.competency_progress" rows="2" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs font-medium text-slate-600 outline-none focus:border-[#D4AF37] rounded-lg resize-none shadow-sm" placeholder="Skills progress..."></textarea>
                                    </td>
                                    <td class="px-4 py-4">
                                        <textarea name="development_progress[]" x-model="row.development_progress" rows="2" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs font-medium text-slate-600 outline-none focus:border-[#D4AF37] rounded-lg resize-none shadow-sm" placeholder="Training/Mentorship..."></textarea>
                                    </td>
                                    <td class="px-4 py-4">
                                        <textarea name="kpi_metrics[]" x-model="row.kpi_metrics" rows="2" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs font-medium text-slate-600 outline-none focus:border-[#D4AF37] rounded-lg resize-none shadow-sm" placeholder="KPI scores..."></textarea>
                                    </td>
                                    <td class="px-4 py-4">
                                        <textarea name="monitoring_progress[]" x-model="row.monitoring_progress" rows="2" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs font-medium text-slate-600 outline-none focus:border-[#D4AF37] rounded-lg resize-none shadow-sm" placeholder="Notes..."></textarea>
                                    </td>
                                    <td class="px-4 py-4">
                                        <select name="readiness_rating[]" required x-model="row.readiness_rating" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-[10px] font-black uppercase text-slate-700 outline-none focus:border-[#D4AF37] rounded-lg">
                                            <template x-for="option in readinessOptions" :key="option">
                                                <option :value="option" x-text="option" :selected="row.readiness_rating == option"></option>
                                            </template>
                                        </select>
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

            <!-- Footer Section: Signatures & Status -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-8 flex flex-col md:flex-row md:items-center justify-between gap-8">
                    <div class="flex-1 space-y-4">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Update Signature / Validation (Optional)</label>
                        <div x-data="{ preview: '{{ $sd->signature_path ? \App\Support\StorageUrl::public($sd->signature_path) : null }}' }" class="space-y-4">
                            <input type="file" name="signature" accept="image/*"
                                   @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }"
                                   class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-slate-900 file:text-white cursor-pointer">
                            <div x-show="preview" class="p-4 border border-dashed border-slate-200 rounded-2xl bg-slate-50 flex items-center justify-center h-32">
                                <img :src="preview" class="max-h-24 rounded-lg shadow-sm" alt="Signature Preview">
                            </div>
                        </div>
                    </div>
                    <div class="flex-shrink-0 space-y-3">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Succession Status</label>
                        <select name="status" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-[#D4AF37] outline-none transition-all font-bold text-slate-700 rounded-xl">
                            <option value="draft" {{ old('status', $sd->status) == 'draft' ? 'selected' : '' }}>Save as Draft</option>
                            <option value="published" {{ old('status', $sd->status) == 'published' ? 'selected' : '' }}>Publish Dashboard</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col items-center pb-12 gap-4">
                <div class="flex items-center gap-4">
                    <button type="submit" 
                            class="bg-[#D4AF37] hover:bg-[#D4AF37]/90 text-white px-16 py-4 rounded-2xl font-black uppercase tracking-widest text-xs transition-all shadow-lg shadow-[#D4AF37]/20 hover:scale-105 active:scale-95">
                        UPDATE SUCCESSION DASHBOARD
                    </button>
                    <button type="reset" class="px-8 py-4 rounded-2xl bg-slate-100 text-slate-400 font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                        Reset
                    </button>
                </div>
                <a href="{{ route('admin.sd.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-rose-500">Cancel & Return</a>
            </div>
        </form>
    </div>
</x-app-layout>
