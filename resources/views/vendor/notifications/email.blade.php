<x-mail::message>
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Aduh, ada masalah!')
@else
# @lang('Halo!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}
@endforeach

{{-- Action Button --}}
@isset($actionText)
@php
    $color = match ($level) {
        'success' => 'success',
        'error'   => 'error',
        default   => 'primary',
    };
@endphp
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}
@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Salam hangat,<br>
**{{ config('app.name') }} Team**
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "Jika Anda kesulitan menekan tombol \":actionText\", silakan salin dan tempel URL di bawah ini\n".
    "ke browser web Anda:",
    [
        'actionText' => $actionText,
    ]
) 

<span class="break-all" style="color: #3498db;">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>