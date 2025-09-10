{{-- Hero Section Component --}}
@if (!empty($featured_posts))
  <section class="py-16 bg-gray-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-8 xl:px-0 relative z-10">
      <div class="flex flex-wrap gap-8 gap-y-8">
        
        {{-- Main Hero Item --}}
        @if (isset($featured_posts[0]))
          @php($main_post = $featured_posts[0])
          <article class="max-w-full w-full flex flex-col lg:flex-row lg:items-center gap-8 lg:gap-12 bg-white shadow-lg rounded-xl p-4 lg:p-6">
            {{-- Hero Image --}}
            <div class="lg:max-w-lg w-full">
              <a href="{{ get_permalink($main_post->ID) }}">
                @if (has_post_thumbnail($main_post->ID))
                  {!! get_the_post_thumbnail($main_post->ID, 'hero-main', [
                    'class' => 'w-full rounded-lg',
                    'alt' => 'hero'
                  ]) !!}
                @else
                  <div class="w-full aspect-[536/320] bg-gray-200 flex items-center justify-center rounded-lg">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                @endif
              </a>
            </div>

            {{-- Hero Content --}}
            <div class="lg:max-w-lg w-full">
              @php($post_categories = get_the_category($main_post->ID))
              @if ($post_categories)
                <a href="{{ get_category_link($post_categories[0]->term_id) }}" 
                   class="inline-flex text-purple-600 bg-purple-50 font-medium text-sm py-1 px-3 rounded-full mb-4">
                  {{ $post_categories[0]->name }}
                </a>
              @endif
              
              <h1 class="font-bold text-2xl xl:text-4xl text-gray-900 mb-4">
                <a href="{{ get_permalink($main_post->ID) }}">
                  {{ get_the_title($main_post->ID) }}
                </a>
              </h1>
              
              <p class="max-w-lg text-gray-600 mb-5">
                {{ wp_trim_words(get_the_excerpt($main_post->ID), 20, '...') }}
              </p>
              
              <div class="flex items-center gap-3 mt-5">
                <a href="{{ get_author_posts_url($main_post->post_author) }}" class="flex items-center gap-3">
                  <div class="flex w-6 h-6 rounded-full overflow-hidden">
                    {!! get_avatar($main_post->post_author, 24, '', '', ['class' => 'w-full h-full object-cover']) !!}
                  </div>
                  <p class="text-sm">{{ get_the_author_meta('display_name', $main_post->post_author) }}</p>
                </a>
                <span class="flex w-[3px] h-[3px] rounded-full bg-gray-400"></span>
                <p class="text-sm">{{ get_the_date('M j, Y', $main_post->ID) }}</p>
              </div>
            </div>
          </article>
        @endif

        {{-- Secondary Hero Items --}}
        @if (count($featured_posts) > 1)
          @foreach(array_slice($featured_posts, 1, 2) as $index => $post)
            @php
              $post_categories = get_the_category($post->ID);
              $category_name = $post_categories ? $post_categories[0]->name : 'General';
              $default_colors = ['text' => 'text-gray-600', 'bg' => 'bg-gray-50'];
              $color_class = isset($category_colors[$category_name]) ? $category_colors[$category_name] : $default_colors;
            @endphp
            
            <article class="lg:max-w-[570px] w-full flex flex-col sm:flex-row sm:items-center gap-6 bg-white shadow-lg rounded-xl p-4">
              {{-- Secondary Image --}}
              <div class="lg:max-w-[238px] w-full">
                <a href="{{ get_permalink($post->ID) }}">
                  @if (has_post_thumbnail($post->ID))
                    {!! get_the_post_thumbnail($post->ID, 'hero-secondary', [
                      'class' => 'w-full rounded-lg',
                      'alt' => 'hero'
                    ]) !!}
                  @else
                    <div class="w-full aspect-[238/180] bg-gray-200 flex items-center justify-center rounded-lg">
                      <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                      </svg>
                    </div>
                  @endif
                </a>
              </div>

              {{-- Secondary Content --}}
              <div class="lg:max-w-[272px] w-full">
                @if ($post_categories)
                  <a href="{{ get_category_link($post_categories[0]->term_id) }}" 
                     class="inline-flex {{ $color_class['text'] }} {{ $color_class['bg'] }} font-medium text-sm py-1 px-3 rounded-full mb-4">
                    {{ $category_name }}
                  </a>
                @endif
                
                <h2 class="font-semibold text-lg text-gray-900 mb-3">
                  <a href="{{ get_permalink($post->ID) }}">
                    {{ get_the_title($post->ID) }}
                  </a>
                </h2>
                
                <div class="flex items-center gap-2">
                  <p class="text-sm">
                    <a href="{{ get_author_posts_url($post->post_author) }}">
                      By {{ get_the_author_meta('display_name', $post->post_author) }}
                    </a>
                  </p>
                  <span class="flex w-[3px] h-[3px] rounded-full bg-gray-400"></span>
                  <p class="text-sm">{{ get_the_date('M j, Y', $post->ID) }}</p>
                </div>
              </div>
            </article>
          @endforeach
        @endif
      </div>
    </div>
  </section>
@endif
