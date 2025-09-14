<footer class="bg-white border-t border-gray-100">
  <div class="max-w-8xl mx-auto px-4 sm:px-8 py-8 sm:py-12">
    
    <!-- Simple Footer Navigation -->
    <nav class="text-center">
      <ul class="flex items-center justify-center flex-wrap gap-6 sm:gap-8 text-sm text-gray-600 font-primary">
        <li><a href="{{ home_url('/about') }}" class="hover:text-black transition-colors">About</a></li>
        <li><a href="{{ home_url('/work') }}" class="hover:text-black transition-colors">Work</a></li>
        <li><a href="{{ home_url('/contact') }}" class="hover:text-black transition-colors">Contact</a></li>
      </ul>
    </nav>
    
    <!-- Copyright -->
    <div class="text-center mt-6 sm:mt-8 text-xs sm:text-sm text-gray-400">
      <p>&copy; {{ date('Y') }} {{ get_bloginfo('name') }}. All rights reserved.</p>
    </div>
    
  </div>
</footer>
