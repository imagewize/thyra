@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    <article @php(post_class(''))>
      {{-- Hero Section with Featured Image --}}
      @if (has_post_thumbnail())
        <section class="relative">
          <div class="aspect-[16/9] lg:aspect-[21/9] overflow-hidden">
            {!! get_the_post_thumbnail(null, 'single-featured', ['class' => 'w-full h-full object-cover']) !!}
          </div>
          
          {{-- Hero Content Overlay --}}
          <div class="absolute inset-0 bg-black bg-opacity-40 flex items-end">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 w-full">
              <div class="text-white">
                @if ($categories)
                  <span class="inline-block text-sm font-medium uppercase tracking-wide mb-4 text-white/80">
                    {{ $categories[0]->name }}
                  </span>
                @endif
                
                <h1 class="text-4xl lg:text-6xl font-bold leading-tight font-serif mb-6">
                  {!! get_the_title() !!}
                </h1>
                
                @if ($subtitle)
                  <p class="text-xl lg:text-2xl text-white/90 mb-6 leading-relaxed max-w-3xl">
                    {{ $subtitle }}
                  </p>
                @endif
                
                <div class="flex items-center space-x-6 text-white/80">
                  <div class="flex items-center space-x-3">
                    @if ($author_avatar)
                      <img src="{{ $author_avatar }}" alt="{{ $author_name }}" class="w-10 h-10 rounded-full">
                    @endif
                    <div>
                      <div class="font-medium">{{ $author_name }}</div>
                      <div class="text-sm text-white/60">{{ get_the_date('M j, Y') }}</div>
                    </div>
                  </div>
                  
                  @if ($read_time)
                    <div class="text-sm">
                      {{ $read_time }} min read
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </section>
      @else
        {{-- Header without featured image --}}
        <header class="py-16 bg-white">
          <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            @if ($categories)
              <span class="inline-block text-sm font-medium text-gray-600 uppercase tracking-wide mb-6">
                {{ $categories[0]->name }}
              </span>
            @endif
            
            <h1 class="text-4xl lg:text-6xl font-bold text-black leading-tight font-serif mb-8">
              {!! get_the_title() !!}
            </h1>
            
            @if ($subtitle)
              <p class="text-xl lg:text-2xl text-gray-600 mb-8 leading-relaxed max-w-3xl mx-auto">
                {{ $subtitle }}
              </p>
            @endif
            
            <div class="flex items-center justify-center space-x-6 text-gray-500">
              <div class="flex items-center space-x-3">
                @if ($author_avatar)
                  <img src="{{ $author_avatar }}" alt="{{ $author_name }}" class="w-10 h-10 rounded-full">
                @endif
                <div class="text-left">
                  <div class="font-medium text-black">{{ $author_name }}</div>
                  <div class="text-sm">{{ get_the_date('M j, Y') }}</div>
                </div>
              </div>
              
              @if ($read_time)
                <div class="text-sm">
                  {{ $read_time }} min read
                </div>
              @endif
            </div>
          </div>
        </header>
      @endif

      {{-- Main Content --}}
      <div class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
            {{-- Article Content --}}
            <div class="lg:col-span-3">
              <div class="prose prose-lg prose-gray max-w-none">
                @php(the_content())
              </div>

              {{-- Post Navigation --}}
              @if ($pagination)
                <nav class="mt-16 pt-8 border-t border-gray-200" aria-label="Page">
                  {!! $pagination !!}
                </nav>
              @endif

              {{-- Tags --}}
              @if ($tags && count($tags) > 0)
                <div class="mt-12 pt-8 border-t border-gray-200">
                  <h3 class="text-sm font-medium text-gray-900 mb-4">Tags</h3>
                  <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                      <a href="{{ get_tag_link($tag->term_id) }}" 
                         class="inline-block px-3 py-1 text-sm bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                        {{ $tag->name }}
                      </a>
                    @endforeach
                  </div>
                </div>
              @endif
            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-1">
              {{-- Author Info --}}
              @if ($author_info)
                <div class="bg-gray-50 p-6 mb-8">
                  <h3 class="text-lg font-bold mb-4">About the Author</h3>
                  <div class="flex items-center space-x-4 mb-4">
                    @if ($author_avatar)
                      <img src="{{ $author_avatar }}" alt="{{ $author_name }}" class="w-16 h-16 rounded-full">
                    @endif
                    <div>
                      <h4 class="font-medium text-black">{{ $author_name }}</h4>
                    </div>
                  </div>
                  @if ($author_bio)
                    <p class="text-gray-600 text-sm">{{ $author_bio }}</p>
                  @endif
                </div>
              @endif

              {{-- Related Posts --}}
              @if ($related_posts && count($related_posts) > 0)
                <div class="mb-8">
                  <h3 class="text-lg font-bold mb-6">Related Articles</h3>
                  <div class="space-y-6">
                    @foreach($related_posts as $related_post)
                      <article class="group">
                        @if (has_post_thumbnail($related_post->ID))
                          <div class="aspect-[4/3] overflow-hidden mb-3">
                            <a href="{{ get_permalink($related_post->ID) }}">
                              {!! get_the_post_thumbnail($related_post->ID, 'thumbnail-fallback', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300']) !!}
                            </a>
                          </div>
                        @endif
                        
                        <h4 class="font-medium text-black group-hover:text-gray-700 transition-colors mb-2">
                          <a href="{{ get_permalink($related_post->ID) }}">
                            {{ get_the_title($related_post->ID) }}
                          </a>
                        </h4>
                        
                        <div class="text-xs text-gray-500">
                          {{ get_the_date('M j, Y', $related_post->ID) }}
                        </div>
                      </article>
                    @endforeach
                  </div>
                </div>
              @endif

              {{-- Newsletter Signup --}}
              <div class="bg-black text-white p-6">
                <h3 class="text-lg font-bold mb-4">Subscribe to Our Newsletter</h3>
                <p class="text-white/80 mb-6 text-sm">Get the latest articles delivered to your inbox.</p>
                
                <form action="{{ admin_url('admin-post.php') }}" method="post" class="space-y-4">
                  <input type="hidden" name="action" value="newsletter_signup">
                  {!! wp_nonce_field('newsletter_signup', 'newsletter_nonce', true, false) !!}
                  <input type="email" 
                         name="email"
                         placeholder="Enter your email" 
                         required
                         class="w-full px-4 py-3 text-black focus:outline-none focus:ring-2 focus:ring-white/50">
                  <button type="submit" 
                          class="w-full px-4 py-3 bg-white text-black font-medium hover:bg-gray-100 transition-colors">
                    Subscribe
                  </button>
                </form>
              </div>
            </aside>
          </div>
        </div>
      </div>

      {{-- Comments --}}
      @php(comments_template())
    </article>
  @endwhile
@endsection
