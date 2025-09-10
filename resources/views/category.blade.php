@extends('layouts.app')

@section('content')
  {{-- Category Header --}}
  <header class="py-16 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center">
        <h1 class="text-4xl lg:text-5xl font-bold text-black leading-tight font-serif mb-6">
          {{ single_cat_title('', false) }}
        </h1>
        
        @if ($category_description)
          <p class="text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto mb-8">
            {{ $category_description }}
          </p>
        @endif
        
        <div class="text-sm text-gray-500">
          {{ $post_count }} {{ $post_count === 1 ? 'article' : 'articles' }} in this category
        </div>
      </div>
    </div>
  </header>

  {{-- Category Posts Grid --}}
  @if ($posts && count($posts) > 0)
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Grid: 3-column desktop, 1-column mobile --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
          @foreach($posts as $post)
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
                  <time>{{ get_the_date('M j, Y', $post->ID) }}</time>
                </div>
              </div>
            </article>
          @endforeach
        </div>

        {{-- Pagination --}}
        @if ($pagination)
          <div class="mt-16 pt-8 border-t border-gray-200">
            {!! $pagination !!}
          </div>
        @endif
      </div>
    </section>
  @else
    {{-- No Posts Found --}}
    <section class="py-20 bg-white text-center">
      <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-black mb-4">No Articles Found</h2>
        <p class="text-gray-600 mb-8">There are currently no published articles in this category.</p>
        <a href="{{ home_url('/') }}" 
           class="inline-block px-8 py-3 border border-black text-black font-medium hover:bg-black hover:text-white transition-all duration-300">
          Back to Homepage
        </a>
      </div>
    </section>
  @endif

  {{-- Related Categories --}}
  @if ($related_categories && count($related_categories) > 0)
    <section class="py-16 bg-gray-50 border-t border-gray-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-black mb-8 text-center">Explore Other Categories</h2>
        
        <div class="flex flex-wrap justify-center gap-4">
          @foreach($related_categories as $category)
            <a href="{{ get_category_link($category->term_id) }}" 
               class="px-6 py-3 bg-white border border-gray-200 text-gray-700 hover:bg-gray-100 hover:border-gray-300 transition-all duration-300 font-medium">
              {{ $category->name }} ({{ $category->count }})
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif
@endsection