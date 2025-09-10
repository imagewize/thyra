<header x-data @scroll.window="stickyHeader = (window.pageYOffset > 50)"
        :class="{ 'bg-white shadow-lg py-4': stickyHeader, 'bg-transparent py-6': !stickyHeader }"
        class="fixed top-0 left-0 right-0 z-40 transition-all duration-300">
    
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ home_url('/') }}" class="text-2xl font-bold text-dark hover:text-primary transition-colors">{!! $siteName !!}</a>
            </div>

            <!-- Desktop Navigation -->
            @if (has_nav_menu('primary_navigation'))
                <nav class="hidden lg:flex items-center space-x-8">
                    {!! wp_nav_menu([
                        'theme_location' => 'primary_navigation',
                        'container' => '',
                        'menu_class' => 'flex items-center space-x-8',
                        'link_class' => 'text-dark-light hover:text-dark font-medium transition-colors',
                        'walker' => new class extends Walker_Nav_Menu {
                            function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
                                if ($item->menu_item_parent == 0) {
                                    if (in_array('menu-item-has-children', $item->classes)) {
                                        $output .= '<div class="relative group">';
                                        $output .= '<button class="flex items-center space-x-1 text-dark-light hover:text-dark font-medium transition-all duration-300 group">';
                                        $output .= '<span>' . $item->title . '</span>';
                                        $output .= '<svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>';
                                        $output .= '</button>';
                                        $output .= '<div class="absolute top-full left-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transform group-hover:translate-y-0 translate-y-2 transition-all duration-300 border border-gray-100 overflow-hidden backdrop-blur-sm">';
                                    } else {
                                        $output .= '<a href="' . $item->url . '" class="text-dark-light hover:text-dark font-medium transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-primary after:transition-all after:duration-300 hover:after:w-full">' . $item->title . '</a>';
                                    }
                                } else {
                                    $output .= '<a href="' . $item->url . '" class="block px-6 py-3 text-sm text-dark-light hover:bg-gray-light hover:text-dark transition-all duration-200 first:rounded-t-2xl last:rounded-b-2xl relative hover:pl-8">' . $item->title . '</a>';
                                }
                            }
                            function end_el(&$output, $item, $depth = 0, $args = null) {
                                if ($item->menu_item_parent == 0) {
                                    if (in_array('menu-item-has-children', $item->classes)) {
                                        $output .= '</div></div>';
                                    }
                                }
                            }
                        },
                        'echo' => false
                    ]) !!}
                </nav>
            @endif

            <!-- Header Actions -->
            <div class="flex items-center space-x-4">
                <!-- Social Links -->
                <div class="hidden sm:flex items-center space-x-2">
                    <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full text-gray-500 hover:text-primary hover:bg-gray-100 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full text-gray-500 hover:text-primary hover:bg-gray-100 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/></svg>
                    </a>
                    <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full text-gray-500 hover:text-primary hover:bg-gray-100 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                </div>
                
                <!-- Search Button -->
                <button @click="searchModal = true" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-50 hover:bg-gray-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                
                <!-- Subscribe Button -->
                <button @click="newsletterModal = true" class="px-6 py-2.5 bg-dark text-white rounded-xl hover:bg-dark-2 transition-all duration-300 font-semibold">
                    Subscribe
                </button>
                
                <!-- Mobile Menu Button -->
                <button @click="mobileMenu = !mobileMenu" class="lg:hidden w-10 h-10 flex items-center justify-center">
                    <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        @if (has_nav_menu('primary_navigation'))
            <div x-show="mobileMenu" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="lg:hidden mt-4 bg-white rounded-lg shadow-lg p-4">
                <nav class="flex flex-col space-y-2">
                    {!! wp_nav_menu([
                        'theme_location' => 'primary_navigation',
                        'container' => '',
                        'menu_class' => 'flex flex-col space-y-2',
                        'link_class' => 'px-3 py-2 text-dark-light hover:text-dark hover:bg-gray-50 rounded font-medium',
                        'echo' => false
                    ]) !!}
                </nav>
            </div>
        @endif
    </div>
</header>
