@props([
    'name',
    'size' => 'md',
])

@php
    $sizeClass = match ($size) {
        'sm' => 'record-avatar--sm',
        'lg' => 'record-avatar--lg',
        default => 'record-avatar--md',
    };

    $initial = mb_strtoupper(mb_substr((string) $name, 0, 1));
@endphp

<div {{ $attributes->merge(['class' => "record-avatar {$sizeClass}"]) }}>
    {{ $initial }}
</div>
