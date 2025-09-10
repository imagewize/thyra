{{-- Hero Section Component --}}
@if (!empty($featured_posts))
<section class="rounded-b-[50px] relative overflow-hidden z-10 pb-15 pt-34 bg-gradient-to-br from-gray-light to-white">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
      
        {{-- Featured Post --}}
        @if (isset($featured_posts[0]))
          @php
            $main_post = $featured_posts[0];
            $post_categories = get_the_category($main_post->ID);
          @endphp
          <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="aspect-w-16 aspect-h-9">
              <a href="{{ get_permalink($main_post->ID) }}">
                @if (has_post_thumbnail($main_post->ID))
                  {!! get_the_post_thumbnail($main_post->ID, 'large', [
                    'class' => 'w-full h-64 object-cover',
                    'alt' => 'Featured post'
                  ]) !!}
                @else
                  <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                @endif
              </a>
            </div>
            <div class="p-6">
              @if ($post_categories)
                <span class="inline-block px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full mb-3">{{ $post_categories[0]->name }}</span>
              @endif
              <h2 class="text-2xl font-bold text-dark mb-3 hover:text-primary transition-colors">
                <a href="{{ get_permalink($main_post->ID) }}">{{ get_the_title($main_post->ID) }}</a>
              </h2>
              <p class="text-gray-600 mb-4">{{ wp_trim_words(get_the_excerpt($main_post->ID), 25, '...') }}</p>
              <div class="flex items-center text-sm text-gray-500">
                <div class="flex w-6 h-6 rounded-full overflow-hidden mr-2">
                  {!! get_avatar($main_post->post_author, 24, '', '', ['class' => 'w-full h-full object-cover']) !!}
                </div>
                <span>By {{ get_the_author_meta('display_name', $main_post->post_author) }}</span>
                <span class="mx-2">•</span>
                <span>{{ get_the_date('M j, Y', $main_post->ID) }}</span>
              </div>
            </div>
          </article>
        @endif

        {{-- Secondary Posts --}}
        @if (count($featured_posts) > 1)
          <div class="space-y-6">
            @foreach(array_slice($featured_posts, 1, 2) as $index => $post)
              @php
                $post_categories = get_the_category($post->ID);
                $category_name = $post_categories ? $post_categories[0]->name : 'General';
                $category_colors_map = [
                  'Technology' => 'bg-blue-100 text-blue-800',
                  'Design' => 'bg-green-100 text-green-800',
                  'Lifestyle' => 'bg-purple-100 text-purple-800',
                  'Business' => 'bg-yellow-100 text-yellow-800',
                  'Travel' => 'bg-red-100 text-red-800',
                  'Productivity' => 'bg-purple-100 text-purple-800'
                ];
                $color_class = $category_colors_map[$category_name] ?? 'bg-gray-100 text-gray-800';
              @endphp
              
              <article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="flex">
                  <div class="w-1/3">
                    <a href="{{ get_permalink($post->ID) }}">
                      @if (has_post_thumbnail($post->ID))
                        {!! get_the_post_thumbnail($post->ID, 'medium', [
                          'class' => 'w-full h-full object-cover',
                          'alt' => 'Post image'
                        ]) !!}
                      @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                          <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                          </svg>
                        </div>
                      @endif
                    </a>
                  </div>
                  <div class="w-2/3 p-4">
                    @if ($post_categories)
                      <span class="inline-block px-2 py-1 text-xs font-medium {{ $color_class }} rounded-full mb-2">{{ $category_name }}</span>
                    @endif
                    <h3 class="font-semibold text-dark mb-2 hover:text-primary transition-colors">
                      <a href="{{ get_permalink($post->ID) }}">{{ get_the_title($post->ID) }}</a>
                    </h3>
                    <div class="flex items-center text-xs text-gray-500">
                      <span>{{ get_the_author_meta('display_name', $post->post_author) }}</span>
                      <span class="mx-2">•</span>
                      <span>{{ get_the_date('M j, Y', $post->ID) }}</span>
                    </div>
                  </div>
                </div>
              </article>
            @endforeach
          </div>
        @endif
    </div>
  </div>
</section>
@endif
