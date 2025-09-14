@php
  $featured_posts = get_posts([
    'numberposts' => 4,
    'post_status' => 'publish',
    'meta_key' => '_thumbnail_id'
  ]);
  
  $main_post = !empty($featured_posts) ? $featured_posts[0] : null;
  $side_posts = !empty($featured_posts) ? array_slice($featured_posts, 1, 3) : [];
@endphp

@unless ($block->preview)
  <section {{ $attributes }} class="py-16 bg-white">
@endunless

<div class="max-w-8xl mx-auto px-4 sm:px-8">
  @if (!empty($featured_posts))
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
      
      {{-- Left: Main Featured Article --}}
      @if ($main_post)
        <article class="group cursor-pointer">
          <a href="{{ get_permalink($main_post->ID) }}" class="block">
            @if (has_post_thumbnail($main_post->ID))
              <div class="aspect-[4/5] mb-6 overflow-hidden bg-gray-100">
                <img src="{{ get_the_post_thumbnail_url($main_post->ID, 'large') }}" 
                     alt="{{ get_the_title($main_post->ID) }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
              </div>
            @endif
            
            <div class="space-y-4">
              {{-- Category --}}
              @php($categories = get_the_category($main_post->ID))
              @if (!empty($categories))
                <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">
                  {{ $categories[0]->name }}
                </div>
              @endif
              
              {{-- Date --}}
              <div class="text-sm text-gray-400">
                {{ get_the_date('M j', $main_post->ID) }}
              </div>
              
              {{-- Title --}}
              <h2 class="text-2xl lg:text-3xl font-normal text-black leading-tight group-hover:text-gray-600 transition-colors">
                {{ get_the_title($main_post->ID) }}
              </h2>
            </div>
          </a>
        </article>
      @endif
      
      {{-- Right: Side Articles Grid --}}
      @if (!empty($side_posts))
        <div class="space-y-8">
          @foreach ($side_posts as $post)
            <article class="flex gap-6 group cursor-pointer">
              <a href="{{ get_permalink($post->ID) }}" class="flex gap-6 flex-1">
                @if (has_post_thumbnail($post->ID))
                  <div class="flex-shrink-0 w-24 h-24 lg:w-32 lg:h-32 overflow-hidden bg-gray-100">
                    <img src="{{ get_the_post_thumbnail_url($post->ID, 'medium') }}" 
                         alt="{{ get_the_title($post->ID) }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                  </div>
                @endif
                
                <div class="flex-1 space-y-2">
                  {{-- Category --}}
                  @php($categories = get_the_category($post->ID))
                  @if (!empty($categories))
                    <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">
                      {{ $categories[0]->name }}
                    </div>
                  @endif
                  
                  {{-- Date --}}
                  <div class="text-sm text-gray-400">
                    {{ get_the_date('M j', $post->ID) }}
                  </div>
                  
                  {{-- Title --}}
                  <h3 class="text-lg font-normal text-black leading-snug group-hover:text-gray-600 transition-colors line-clamp-2">
                    {{ get_the_title($post->ID) }}
                  </h3>
                </div>
              </a>
            </article>
          @endforeach
        </div>
      @endif
      
    </div>
  @else
    {{-- Fallback when no posts --}}
    <div class="text-center py-16">
      <p class="text-gray-500">No featured posts available</p>
    </div>
  @endif
</div>

@unless ($block->preview)
  </section>
@endunless
