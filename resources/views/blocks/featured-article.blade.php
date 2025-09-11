@unless ($block->preview)
  <section {{ $attributes->merge(['class' => 'py-16 bg-white']) }}>
@endunless

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
    
    {{-- Featured Image --}}
    <div class="order-2 lg:order-1">
      @if ($featured_image && !empty($featured_image['url']))
        <div class="aspect-[4/5] overflow-hidden">
          <img src="{{ $featured_image['url'] }}" 
               alt="{{ $featured_image['alt'] ?? '' }}" 
               class="w-full h-full object-cover">
        </div>
      @endif
    </div>
    
    {{-- Featured Content --}}
    <div class="order-1 lg:order-2 space-y-6">
      @if ($headline)
        <h1 class="text-4xl lg:text-5xl font-bold text-black leading-tight font-serif">
          @if ($article_type !== 'manual' && $selected_post)
            <a href="{{ get_permalink($selected_post->ID) }}" class="hover:text-gray-700 transition-colors">
              {{ $headline }}
            </a>
          @else
            {{ $headline }}
          @endif
        </h1>
      @endif
      
      @if ($subtitle)
        <p class="text-lg text-gray-600 leading-relaxed">
          {{ $subtitle }}
        </p>
      @endif
      
      @if ($article_type !== 'manual' && $selected_post)
        <div class="flex items-center space-x-4 text-sm text-gray-500">
          <div class="flex items-center space-x-2">
            {!! get_avatar(get_the_author_meta('ID', $selected_post->post_author), 32, '', '', ['class' => 'w-8 h-8 rounded-full']) !!}
            <span class="font-medium">{{ get_the_author_meta('display_name', $selected_post->post_author) }}</span>
          </div>
          <span>•</span>
          <time>{{ get_the_date('M j, Y', $selected_post->ID) }}</time>
        </div>
      @endif
    </div>
    
  </div>
</div>

@unless ($block->preview)
  </section>
@endunless
