@props([
    'path' => null,
    'alt' => 'Image',
    'class' => 'h-20 object-contain',
])

@if($path)
    <img src="{{ \App\Support\StorageUrl::public($path) }}" alt="{{ $alt }}" {{ $attributes->merge(['class' => $class]) }}>
@endif
