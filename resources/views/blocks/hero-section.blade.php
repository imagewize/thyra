@unless ($block->preview)
  <section {{ $attributes }} class="relative min-h-screen flex items-center justify-center overflow-hidden">
@endunless

{{-- Background Image --}}
@if (!empty($background_image))
  <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
       style="background-image: url('{{ $background_image['url'] }}')">
  </div>
@else
  <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-purple-700">
  </div>
@endif

{{-- Overlay --}}
<div class="absolute inset-0 bg-black" 
     style="opacity: {{ ($overlay_opacity ?? 60) / 100 }}">
</div>

{{-- Content --}}
<div class="relative z-10 text-center text-white px-6 max-w-4xl mx-auto">
  @if (!empty($headline))
    <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
      {{ $headline }}
    </h1>
  @endif

  @if (!empty($subheadline))
    <p class="text-xl md:text-2xl mb-8 opacity-90 max-w-2xl mx-auto">
      {{ $subheadline }}
    </p>
  @endif

  @if (!empty($cta_text) && !empty($cta_url))
    <a href="{{ $cta_url }}" 
       class="inline-block px-8 py-4 text-lg font-semibold rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-lg"
       style="background-color: {{ $accent_color ?? '#3B82F6' }}; color: white;">
      {{ $cta_text }}
    </a>
  @endif
</div>

@unless ($block->preview)
  </section>
@endunless
