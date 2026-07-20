@props(['iso2' => null, 'size' => '20x15', 'class' => '', 'style' => ''])

@if($iso2)
<img
    src="https://flagcdn.com/{{ $size }}/{{ strtolower($iso2) }}.png"
    alt="{{ $iso2 }} flag"
    title="{{ $iso2 }}"
    loading="lazy"
    class="country-flag {{ $class }}"
    style="border-radius:2px; vertical-align:middle; display:inline-block; object-fit:cover; {{ $style }}"
    onerror="this.style.display='none'"
>
@endif
