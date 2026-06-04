@props([
    'name',
    'title',
    'description',
    'sections' => [],
])

<div class="flex items-center gap-3">
    <button
        type="button"
        x-data
        @click="$dispatch('open-modal', '{{ $name }}')"
        class="inline-flex items-center justify-center w-11 h-11 rounded-full border border-slate-200 bg-white text-slate-700 shadow-sm hover:bg-slate-50 hover:text-slate-900 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#00ADC5]/30"
        title="View Module Guide"
        aria-label="View Module Guide"
    >
        <i data-lucide="info" class="w-5 h-5"></i>
    </button>

    <x-modal name="{{ $name }}" maxWidth="2xl" focusable>
        <div class="bg-white rounded-[1.5rem] overflow-hidden">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 p-6 border-b border-slate-200">
                <div class="space-y-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#00ADC5]/10 text-[#00ADC5] text-xs font-black uppercase tracking-[0.35em]">
                        <i data-lucide="info" class="w-4 h-4"></i>
                        Module Guide
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 leading-tight">{{ $title }}</h2>
                        <p class="text-sm text-slate-500 mt-1 leading-relaxed">{{ $description }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-end">
                    <button type="button" @click="$dispatch('close-modal', '{{ $name }}')" class="rounded-2xl bg-slate-100 p-3 text-slate-500 hover:bg-slate-200 hover:text-slate-900 transition-all duration-200">
                        <span class="sr-only">Close module guide</span>
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <div class="p-6 space-y-6 max-h-[75vh] overflow-y-auto">
                @foreach($sections as $section)
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="flex items-center justify-center w-11 h-11 rounded-2xl bg-[#00ADC5]/10 text-[#00ADC5] flex-shrink-0">
                                <i data-lucide="{{ $section['icon'] ?? 'info' }}" class="w-5 h-5"></i>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-sm font-black text-slate-900 uppercase tracking-[0.25em]">{{ $section['title'] }}</h3>
                                @if(is_array($section['content']))
                                    <ul class="list-disc list-inside text-sm text-slate-600 space-y-2">
                                        @foreach($section['content'] as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-sm text-slate-600 leading-relaxed">{{ $section['content'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end gap-3 p-4 border-t border-slate-200 bg-slate-50">
                <button type="button" @click="$dispatch('close-modal', '{{ $name }}')" class="px-5 py-3 rounded-2xl bg-[#111111] text-white text-sm font-black uppercase tracking-[0.18em] hover:bg-[#00333B] transition-all duration-200">
                    Close Guide
                </button>
            </div>
        </div>
    </x-modal>
</div>
