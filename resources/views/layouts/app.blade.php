<!doctype html>
<html @php(language_attributes())>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php(do_action('get_header'))
    @php(wp_head())

    <!-- Inter Font for Enhanced Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  </head>

  <body @php(body_class()) 
        class="min-h-screen bg-white font-sans"
        x-data="{ 
          loaded: true, 
          mobileMenu: false, 
          searchModal: false, 
          newsletterModal: false, 
          stickyHeader: false,
          selectedCategory: 'All'
        }" 
        x-init="window.addEventListener('DOMContentLoaded', () => {setTimeout(() => loaded = false, 800)})">
    @php(wp_body_open())

    <!-- Loading Screen -->
    <div x-show="loaded" 
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-white">
        <div class="w-16 h-16 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
    </div>

    <div id="app" class="min-h-screen">
      <a class="sr-only focus:not-sr-only bg-blue-600 text-white px-4 py-2 rounded" href="#main">
        {{ __('Skip to content', 'sage') }}
      </a>

      @include('sections.header')

      <main id="main" class="main">
        @yield('content')
      </main>

      @hasSection('sidebar')
        <aside class="sidebar bg-gray-50">
          <div class="max-w-7xl mx-auto px-4 py-12">
            @yield('sidebar')
          </div>
        </aside>
      @endif

      @include('sections.footer')
    </div>

    <!-- Search Modal -->
    <div x-show="searchModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-start justify-center pt-16 px-4"
         @keydown.escape="searchModal = false">
        
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="searchModal = false"></div>
        
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl relative z-10 border border-gray-100 transform transition-all duration-300"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            <div class="p-6">
                <form role="search" method="get" action="{{ home_url('/') }}" class="flex items-center space-x-4 mb-4">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="search" 
                           name="s"
                           placeholder="Search articles, categories, authors..." 
                           class="flex-1 text-lg border-0 outline-none focus:ring-0"
                           x-ref="searchInput"
                           x-init="$nextTick(() => $refs.searchInput.focus())">
                    <button @click="searchModal = false" type="button" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </form>
                
                <div class="border-t pt-4">
                    <h5 class="text-sm font-medium text-gray-500 mb-3">Popular Searches</h5>
                    <div class="space-y-2">
                        @php($popular_tags = get_tags(['number' => 3, 'orderby' => 'count', 'order' => 'DESC']))
                        @foreach($popular_tags as $tag)
                            <a href="{{ get_tag_link($tag->term_id) }}" class="block p-2 hover:bg-gray-50 rounded cursor-pointer">
                                <div class="font-medium">{{ $tag->name }}</div>
                                <div class="text-sm text-gray-500">{{ $tag->count }} posts</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Newsletter Modal -->
    <div x-show="newsletterModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center px-4"
         @keydown.escape="newsletterModal = false">
        
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="newsletterModal = false"></div>
        
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md relative z-10 p-8 border border-gray-100 transform transition-all duration-300"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-dark">Subscribe to Newsletter</h3>
                <button @click="newsletterModal = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <p class="text-dark-light mb-6 leading-relaxed">Get the latest articles and insights delivered to your inbox weekly.</p>
            
            <form class="space-y-4" action="{{ admin_url('admin-post.php') }}" method="post">
                <input type="hidden" name="action" value="newsletter_signup">
                {!! wp_nonce_field('newsletter_signup', 'newsletter_nonce', true, false) !!}
                <input type="email" 
                       name="email"
                       placeholder="Your email address" 
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none">
                <button type="submit" 
                        class="w-full py-3 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark transition-all duration-300">
                    Subscribe Now
                </button>
            </form>
            
            <p class="text-xs text-gray-500 mt-4 text-center">We respect your privacy. Unsubscribe at any time.</p>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button x-show="stickyHeader" 
            @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="fixed bottom-8 right-8 w-12 h-12 bg-primary text-white rounded-full shadow-lg hover:bg-primary-dark hover:shadow-xl hover:shadow-primary/25 transition-all duration-300 z-40 flex items-center justify-center">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    @php(do_action('get_footer'))
    @php(wp_footer())
  </body>
</html>
