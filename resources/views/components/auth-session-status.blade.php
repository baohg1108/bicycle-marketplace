@props(['status'])

@if ($status)
    < {{ $attributes->merge(['class' => 'alert alert-success']) }}>
        {{ $status }}
        </div>
@endif
