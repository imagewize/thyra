@extends('layouts.app')

@section('content')
  {{-- Static Page Content --}}
  @if (have_posts())
    @while (have_posts()) @php(the_post())
      <article class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          {{-- Page Header --}}
          <header class="text-center mb-12">
            <h1 class="text-4xl lg:text-5xl font-bold text-black leading-tight font-serif mb-6">
              {{ get_the_title() }}
            </h1>
            
            @if (get_the_excerpt())
              <p class="text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
                {{ get_the_excerpt() }}
              </p>
            @endif
          </header>

          {{-- Featured Image --}}
          @if (has_post_thumbnail())
            <div class="mb-12">
              <div class="aspect-[16/9] overflow-hidden">
                {!! get_the_post_thumbnail(null, 'single-featured', ['class' => 'w-full h-full object-cover']) !!}
              </div>
            </div>
          @endif

          {{-- Page Content --}}
          <div class="prose prose-lg prose-gray max-w-none">
            @php(the_content())
          </div>
        </div>
      </article>
    @endwhile
  @endif

  {{-- Latest Blog Posts Section (optional) --}}
  @if (!empty($latest_posts))
    <section class="py-20 bg-gray-50 border-t border-gray-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <header class="text-center mb-16">
          <h2 class="text-3xl font-bold text-black mb-4">Latest Articles</h2>
          <p class="text-gray-600">Stay up to date with our newest content</p>
        </header>

        {{-- Grid: 3-column desktop, 1-column mobile --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
          @foreach($latest_posts as $post)
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

                <h3 class="text-xl font-bold text-black leading-tight group-hover:text-gray-700 transition-colors">
                  <a href="{{ get_permalink($post->ID) }}">
                    {{ get_the_title($post->ID) }}
                  </a>
                </h3>

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

        {{-- View All Posts Link --}}
        <div class="text-center mt-16">
          <a href="{{ get_permalink(get_option('page_for_posts')) ?: home_url('/blog') }}" 
             class="inline-block px-8 py-3 border border-black text-black font-medium hover:bg-black hover:text-white transition-all duration-300">
            View All Posts
          </a>
        </div>
      </div>
    </section>
  @endif
@endsection