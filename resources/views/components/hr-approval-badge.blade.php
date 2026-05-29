@props(['status' => 'Pending'])

@php
    $status = $status ?? 'Pending';
    $badgeClass = match ($status) {
        'Approved' => 'hr-status-badge hr-status-badge--approved',
        'Rejected' => 'hr-status-badge hr-status-badge--rejected',
        default => 'hr-status-badge hr-status-badge--pending',
    };
@endphp

<span {{ $attributes->merge(['class' => $badgeClass]) }}>
    <span class="hr-status-badge__dot"></span>
    {{ $status }}
</span>
