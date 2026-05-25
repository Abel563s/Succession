@props([
    'name' => 'signature',
    'label' => 'Signature',
    'required' => false,
    'allowSaved' => true,
    'savedUrl' => null,
    'savedLabel' => 'Use my saved signature',
])

@php
    $savedUrl = $savedUrl ?? (auth()->user()?->signature_path ? \App\Support\StorageUrl::public(auth()->user()->signature_path) : null);
    $canUseSaved = $allowSaved && (auth()->user()?->isManager() || auth()->user()?->isDceo()) && $savedUrl;
@endphp

<div {{ $attributes->merge(['class' => 'space-y-4']) }} x-data="{ mode: '{{ $canUseSaved ? 'saved' : 'upload' }}', preview: null, sizeError: null }">
    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">{{ $label }}</label>

    @if($canUseSaved)
        <div class="flex flex-wrap gap-3">
            <label class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border cursor-pointer transition-all"
                   :class="mode === 'saved' ? 'border-[#00ADC5] bg-[#f0fbfd] text-[#00515F]' : 'border-slate-200 bg-white text-slate-500'">
                <input type="radio" name="signature_mode_{{ $name }}" value="saved" class="sr-only" x-model="mode">
                <i data-lucide="bookmark" class="w-4 h-4"></i>
                <span class="text-[10px] font-black uppercase tracking-widest">{{ $savedLabel }}</span>
            </label>
            <label class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border cursor-pointer transition-all"
                   :class="mode === 'upload' ? 'border-[#00ADC5] bg-[#f0fbfd] text-[#00515F]' : 'border-slate-200 bg-white text-slate-500'">
                <input type="radio" name="signature_mode_{{ $name }}" value="upload" class="sr-only" x-model="mode">
                <i data-lucide="upload" class="w-4 h-4"></i>
                <span class="text-[10px] font-black uppercase tracking-widest">Upload new</span>
            </label>
        </div>
        <input type="hidden" name="use_saved_signature" value="0" x-bind:value="mode === 'saved' ? 1 : 0">
        <div x-show="mode === 'saved'" x-cloak class="p-4 border border-slate-100 rounded-2xl bg-slate-50 flex items-center justify-center">
            <img src="{{ $savedUrl }}" class="max-h-20 max-w-full object-contain rounded-xl shadow-sm border border-white" alt="Saved signature">
        </div>
    @endif

    <div x-show="{{ $canUseSaved ? "mode === 'upload'" : 'true' }}" x-cloak>
        <input type="file" name="{{ $name }}" accept="image/*"
               @if($required && ! $canUseSaved) required @endif
               @if($required && $canUseSaved) x-bind:required="mode === 'upload'" @endif
               @change="
                   sizeError = null;
                   const file = $event.target.files[0];
                   if (file) {
                       if (file.size > 512000) {
                           sizeError = 'File too large. Maximum allowed size is 500KB.';
                           $event.target.value = '';
                           preview = null;
                       } else {
                           const reader = new FileReader();
                           reader.onload = (e) => preview = e.target.result;
                           reader.readAsDataURL(file);
                       }
                   } else { preview = null; }"
               class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-slate-900 file:text-white cursor-pointer">
        <div x-show="sizeError" class="mt-1.5 flex items-center gap-1.5">
            <i data-lucide="alert-circle" class="w-3 h-3 text-rose-500"></i>
            <p x-text="sizeError" class="text-[10px] font-bold text-rose-500"></p>
        </div>
        <p class="mt-1 text-[10px] text-slate-400 font-medium">Max file size: 500KB &bull; Accepted formats: JPG, PNG, GIF</p>
        <div x-show="preview" x-transition class="mt-3 p-3 border border-dashed border-slate-200 rounded-2xl bg-slate-50 flex items-center justify-center overflow-hidden">
            <img :src="preview" class="max-h-20 max-w-full object-contain rounded-xl shadow-sm" alt="Signature preview">
        </div>
    </div>
</div>
