@extends('layouts.app')

@section('content')
  {{-- Hero Section --}}
  @include('partials.hero-section')

  <!-- Categories Section -->
  <section class="pt-20 lg:pt-25 pb-15 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
      <div class="text-center mb-12">
        <h2 class="text-3xl lg:text-4xl font-bold text-dark mb-4 leading-tight">Browse by Category</h2>
        <p class="text-dark-light max-w-2xl mx-auto leading-relaxed">Explore our diverse collection of articles across various topics and find content that interests you most.</p>
      </div>

      <!-- Category Filter -->
      @if (!empty($categories))
        <div class="flex flex-wrap justify-center gap-3 mb-12">
          <button class="px-4 py-2 bg-dark text-white rounded-full transition-colors font-medium">
            All ({{ wp_count_posts()->publish }})
          </button>
          @foreach($categories as $category)
            <button class="px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-full transition-colors font-medium" 
                    onclick="window.location.href='{{ get_category_link($category->term_id) }}'">
              {{ $category->name }} ({{ $category->count }})
            </button>
          @endforeach
        </div>
      @endif

      <!-- Posts Grid -->
      @if (!empty($latest_posts))
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
          @foreach($latest_posts as $post)
            <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-500 group border border-gray-border transform hover:scale-[1.02]">
              <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                @if (has_post_thumbnail($post->ID))
                  {!! get_the_post_thumbnail($post->ID, 'medium_large', ['class' => 'w-full h-48 object-cover group-hover:scale-110 transition-transform duration-700 ease-out']) !!}
                @else
                  <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                @endif
              </div>
              <div class="p-6">
                @php($post_categories = get_the_category($post->ID))
                @if ($post_categories)
                  @php($color_class = $category_colors[$post_categories[0]->name] ?? $category_colors['default'])
                  <span class="inline-block px-3 py-1.5 text-xs font-semibold border {{ $color_class }} rounded-full mb-3 transition-all duration-300 backdrop-blur-sm">
                    {{ $post_categories[0]->name }}
                  </span>
                @endif
                <h3 class="text-xl font-bold text-dark mb-3 group-hover:text-primary transition-colors leading-snug">
                  <a href="{{ get_permalink($post->ID) }}">{{ get_the_title($post->ID) }}</a>
                </h3>
                <p class="text-dark-light mb-4 leading-relaxed">{{ wp_trim_words(get_the_excerpt($post->ID), 20, '...') }}</p>
                <div class="flex items-center text-sm text-gray-500">
                  {!! get_avatar(get_the_author_meta('ID', $post->post_author), 24, '', '', ['class' => 'w-6 h-6 rounded-full mr-2']) !!}
                  <span>{{ get_the_author_meta('display_name', $post->post_author) }}</span>
                  <span class="mx-2">•</span>
                  <span>{{ get_the_date('M j, Y', $post->ID) }}</span>
                </div>
              </div>
            </article>
          @endforeach
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-12">
          <a href="{{ get_permalink(get_option('page_for_posts')) ?: home_url('/') }}" class="inline-flex items-center px-8 py-4 border-2 border-dark text-dark hover:bg-dark hover:text-white transition-all duration-300 rounded-xl font-semibold tracking-wide hover:shadow-lg hover:shadow-dark/25 transform hover:-translate-y-1 group">
            <span>Load More Posts</span>
            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg>
          </a>
        </div>
      @endif
    </div>
  </section>

  <!-- Authors Section -->
  @if (!empty($authors))
  <section class="pb-15 bg-gray-light">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between mb-12">
        <h2 class="text-3xl font-bold text-dark">Top Authors</h2>
        <a href="#" class="text-primary hover:text-primary-dark transition-colors font-medium flex items-center">
          All Authors
          <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
        </a>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($authors as $author)
          <div class="bg-white rounded-xl p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-start space-x-4">
              <div class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0">
                {!! get_avatar($author->ID, 64, '', '', ['class' => 'w-full h-full object-cover']) !!}
              </div>
              <div class="flex-1">
                <h3 class="font-semibold text-dark mb-1">{{ $author->display_name }}</h3>
                <p class="text-gray-600 text-sm mb-2">
                  @if (get_user_meta($author->ID, 'description', true))
                    {{ get_user_meta($author->ID, 'description', true) }}
                  @else
                    Writer & Content Creator
                  @endif
                </p>
                <div class="flex items-center text-xs text-gray-500">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <span>{{ count_user_posts($author->ID, 'post') }} Published Posts</span>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <!-- Newsletter Section -->
  <section class="py-12_5 bg-gradient-to-r from-primary to-primary-dark relative overflow-hidden z-10">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
      <h2 class="text-3xl font-bold text-white mb-4">Stay Updated</h2>
      <p class="text-blue-100 mb-8 max-w-2xl mx-auto">Get the latest articles delivered straight to your inbox. No spam, just quality content you'll love.</p>
      
      <form class="flex flex-col sm:flex-row max-w-md mx-auto gap-4" action="{{ admin_url('admin-post.php') }}" method="post">
        <input type="hidden" name="action" value="newsletter_signup">
        {!! wp_nonce_field('newsletter_signup', 'newsletter_nonce', true, false) !!}
        <input type="email" 
               name="email"
               placeholder="Enter your email" 
               required
               class="flex-1 px-4 py-3 rounded-lg border-0 focus:ring-4 focus:ring-white focus:ring-opacity-25 outline-none">
        <button type="submit" 
                class="px-6 py-3 bg-white text-primary font-semibold rounded-xl hover:bg-gray-100 transition-all duration-300">
          Subscribe
        </button>
      </form>
    </div>
  </section>
@endsection
