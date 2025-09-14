@unless ($block->preview)
  <section {{ $attributes->merge(['class' => 'py-16 bg-white']) }}>
@endunless

<div class="max-w-8xl mx-auto px-4 sm:px-8">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    {{-- Featured Image (Left - Takes 1 column) --}}
    <div class="lg:col-span-1">
      @if ($featured_image && !empty($featured_image['url']))
        <div class="aspect-[3/4] overflow-hidden bg-gray-100">
          @if ($article_type !== 'manual' && $selected_post)
            <a href="{{ get_permalink($selected_post->ID) }}">
              <img src="{{ $featured_image['url'] }}" 
                   alt="{{ $featured_image['alt'] ?? '' }}" 
                   class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
            </a>
          @else
            <img src="{{ $featured_image['url'] }}" 
                 alt="{{ $featured_image['alt'] ?? '' }}" 
                 class="w-full h-full object-cover">
          @endif
        </div>
      @endif
    </div>
    
    {{-- Featured Content (Right - Takes 2 columns) --}}
    <div class="lg:col-span-2 space-y-6">
      @if ($headline)
        <h1 class="text-3xl lg:text-4xl font-normal text-black leading-tight">
          @if ($article_type !== 'manual' && $selected_post)
            <a href="{{ get_permalink($selected_post->ID) }}" class="hover:text-gray-600 transition-colors">
              {{ $headline }}
            </a>
          @else
            {{ $headline }}
          @endif
        </h1>
      @endif
      
      @if ($subtitle)
        <h2 class="text-xl font-normal text-black leading-relaxed">
          {{ $subtitle }}
        </h2>
        <div class="w-12 h-px bg-black"></div>
      @endif
      
      @if ($article_type !== 'manual' && $selected_post)
        <div class="text-sm text-gray-400">
          <time>{{ get_the_date('M j', $selected_post->ID) }}</time>
        </div>
      @endif
    </div>
    
  </div>
</div>

@unless ($block->preview)
  </section>
@endunless
