@props(['status' => 'Pending'])

@php
    $status = $status ?? 'Pending';
    $badgeColor = match ($status) {
        'Approved' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
        'Rejected' => 'bg-rose-50 text-rose-600 border-rose-100',
        default => 'bg-amber-50 text-amber-600 border-amber-100',
    };
    $dotColor = match ($status) {
        'Approved' => 'bg-emerald-500',
        'Rejected' => 'bg-rose-500',
        default => 'bg-amber-500',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {$badgeColor}"]) }}>
    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
    {{ $status }}
</span>
