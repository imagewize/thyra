@extends('layouts.app')

@section('content')
  {{-- Featured Story Hero Section --}}
  @if (!empty($featured_posts))
    @php($main_post = $featured_posts[0])
    <section class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          {{-- Featured Image --}}
          <div class="order-2 lg:order-1">
            @if (has_post_thumbnail($main_post->ID))
              <div class="aspect-[4/5] overflow-hidden">
                {!! get_the_post_thumbnail($main_post->ID, 'homepage-featured', ['class' => 'w-full h-full object-cover']) !!}
              </div>
            @endif
          </div>
          
          {{-- Featured Content --}}
          <div class="order-1 lg:order-2 space-y-6">
            @php($post_categories = get_the_category($main_post->ID))
            @if ($post_categories)
              <span class="inline-block text-sm font-medium text-gray-600 uppercase tracking-wide">
                {{ $post_categories[0]->name }}
              </span>
            @endif
            
            <h1 class="text-4xl lg:text-5xl font-bold text-black leading-tight font-serif">
              <a href="{{ get_permalink($main_post->ID) }}" class="hover:text-gray-700 transition-colors">
                {{ get_the_title($main_post->ID) }}
              </a>
            </h1>
            
            <p class="text-lg text-gray-600 leading-relaxed">
              {{ wp_trim_words(get_the_excerpt($main_post->ID), 30, '...') }}
            </p>
            
            <div class="flex items-center space-x-4 text-sm text-gray-500">
              <div class="flex items-center space-x-2">
                {!! get_avatar(get_the_author_meta('ID', $main_post->post_author), 32, '', '', ['class' => 'w-8 h-8 rounded-full']) !!}
                <span class="font-medium">{{ get_the_author_meta('display_name', $main_post->post_author) }}</span>
              </div>
              <span>•</span>
              <time>{{ get_the_date('M j, Y', $main_post->ID) }}</time>
            </div>
          </div>
        </div>
      </div>
    </section>
  @endif

  {{-- Magazine Grid Layout --}}
  @if (!empty($latest_posts))
    <section class="py-20 bg-white border-t border-gray-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Grid: 3-column desktop, 1-column mobile --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
          @foreach($latest_posts as $index => $post)
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

                <h2 class="text-xl font-bold text-black leading-tight group-hover:text-gray-700 transition-colors">
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

        {{-- Load More --}}
        <div class="text-center mt-16">
          <a href="{{ get_permalink(get_option('page_for_posts')) ?: home_url('/') }}" 
             class="inline-block px-8 py-3 border border-black text-black font-medium hover:bg-black hover:text-white transition-all duration-300">
            View All Posts
          </a>
        </div>
      </div>
    </section>
  @endif

  {{-- Newsletter Subscription --}}
  <section class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h2 class="text-2xl font-bold text-black mb-4">Subscribe to Our Newsletter</h2>
      <p class="text-gray-600 mb-8">Get the latest articles delivered to your inbox.</p>
      
      <form class="max-w-md mx-auto" action="{{ admin_url('admin-post.php') }}" method="post">
        <input type="hidden" name="action" value="newsletter_signup">
        {!! wp_nonce_field('newsletter_signup', 'newsletter_nonce', true, false) !!}
        <div class="flex space-x-4">
          <input type="email" 
                 name="email"
                 placeholder="Enter your email" 
                 required
                 class="flex-1 px-4 py-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
          <button type="submit" 
                  class="px-6 py-3 bg-black text-white font-medium hover:bg-gray-800 transition-colors duration-300">
            Subscribe
          </button>
        </div>
      </form>
    </div>
  </section>
@endsection
