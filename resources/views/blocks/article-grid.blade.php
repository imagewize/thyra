@unless ($block->preview)
  <section {{ $attributes->merge(['class' => 'py-20 bg-white border-t border-gray-100']) }}>
@endunless

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  
  @if (!empty($posts))
    {{-- Grid: 3-column desktop, 1-column mobile --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
      @foreach($posts as $index => $post)
        <article class="space-y-4 group">
          
          {{-- Post Thumbnail --}}
          @if (has_post_thumbnail($post->ID))
            <div class="aspect-[4/5] overflow-hidden">
              <a href="{{ get_permalink($post->ID) }}">
                {!! get_the_post_thumbnail($post->ID, 'homepage-featured', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500']) !!}
              </a>
            </div>
          @endif

          {{-- Post Meta --}}
          <div class="space-y-3">
            @php($post_categories = get_the_category($post->ID))
            @if ($post_categories)
              <span class="inline-block text-xs font-medium text-gray-500 uppercase tracking-wide">
                {{ $post_categories[0]->name }}
              </span>
            @endif

            <h2 class="text-xl font-normal text-black leading-tight group-hover:text-gray-600 transition-colors">
              <a href="{{ get_permalink($post->ID) }}">
                {{ get_the_title($post->ID) }}
              </a>
            </h2>

            <p class="text-gray-600 text-sm leading-relaxed">
              {{ wp_trim_words(get_the_excerpt($post->ID), 15, '...') }}
            </p>

            <div class="flex items-center space-x-2 text-xs text-gray-500">
              <span class="font-medium">{{ get_the_author_meta('display_name', $post->post_author) }}</span>
              <span>•</span>
              <time>{{ get_the_date('M j', $post->ID) }}</time>
            </div>
          </div>
          
        </article>
      @endforeach
    </div>

    {{-- Load More Button --}}
    <div class="text-center mt-16">
      <a href="{{ get_permalink(get_option('page_for_posts')) ?: home_url('/') }}" 
         class="inline-block px-8 py-3 border border-black text-black font-medium hover:bg-black hover:text-white transition-all duration-300">
        View All Posts
      </a>
    </div>
    
  @else
    @if ($block->preview)
      <p class="text-center text-gray-500 py-8">No posts found. Add some posts with featured images to see them here.</p>
    @endif
  @endif
  
</div>

@unless ($block->preview)
  </section>
@endunless
