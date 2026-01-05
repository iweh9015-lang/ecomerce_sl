@props(['status'])

@php
$classes = [
    'pending' => 'badge bg-warning text-dark',
    'processing' => 'badge bg-primary',
    'completed' => 'badge bg-success',
    'cancelled' => 'badge bg-danger',
];
$class = $classes[$status] ?? 'badge bg-secondary';
@endphp

<span class="{{ $class }}">
    {{ ucfirst($status) }}
</span>