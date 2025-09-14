# 🎨 Thaiconomics-Inspired Design System

## 📊 Design Analysis Overview

Based on the analysis of `https://thaiconomics.smtv.test`, this document provides a complete redesign roadmap to achieve a sophisticated, minimalist magazine-style layout inspired by the Thaiconomics design. This approach focuses on clean typography, generous whitespace, and editorial design patterns.

---

## 🔍 Key Design Characteristics

### Design Philosophy: **Minimalist Editorial**

- **Clean, spacious layout** with extensive whitespace
- **Editorial typography** with large, readable fonts
- **Magazine-style grid** with asymmetric layouts
- **Understated color palette** (black, white, subtle grays)
- **High-quality imagery** as primary visual elements
- **Simple navigation** without decorative elements

### Visual Hierarchy Analysis

**Desktop Homepage Layout Structure:**
```
┌─────────────────────────────────────┐
│           Thyra (Lato)              │
│               ────                   │
│                                     │
│  [IMG1]    [IMG2]    [IMG3]         │
│  Title 1   Title 2   Title 3        │
│  Date      Date      Date           │
│                                     │
│  [Large IMG]  [Long Text Block]     │
│  Title            Content...        │
│  Date                               │
│                                     │
│          About Work Contact          │
└─────────────────────────────────────┘
```

**Mobile Homepage Layout Structure:**
```
┌─────────────────────┐
│    ☰  Thyra (Lato)  │
│                     │
│                     │
│     [Hero Image]    │
│                     │
│                     │
│      [Image 2]      │
│                     │
│                     │
│      [Image 3]      │
│                     │
│                     │
│   About Work Contact │
└─────────────────────┘
```

**Desktop Single Post Layout:**
```
┌─────────────────────────────────────┐
│           Thyra (Lato)              │
│               ────                   │
│                                     │
│         [Hero Image]                │
│                                     │
│        Large Title                  │ 
│        Subtitle                     │
│                                     │
│        Body text in              │[Subscribe Box]
│        narrow column             │[Author Info]
│        with comfortable          │
│        line spacing              │
│                                     │
│        [Content Images]             │
│                                     │
│          About Work Contact          │
└─────────────────────────────────────┘
```

**Mobile Single Post Layout:**
```
┌─────────────────────┐
│    ☰  Thyra (Lato)  │
│                     │
│     [Hero Image]    │
│                     │
│     Large Title     │
│      Subtitle       │
│                     │
│    Body text in     │
│   single column     │
│   with comfortable  │
│    line spacing     │
│                     │
│  [Subscribe Box]    │
│   [Author Info]     │
│                     │
│   About Work Contact │
└─────────────────────┘
```

### Mobile Design Analysis

Based on the mobile screenshot from `screenshots/thaiconomics-homepage-mobile.png`, the Thaiconomics site demonstrates perfect mobile adaptation:

**Mobile Design Characteristics:**
- **Single-column layout** - All content stacks vertically
- **Full-width images** - Hero images take full container width
- **Hamburger navigation** (☰) - Collapsed menu for mobile
- **Maintained typography hierarchy** - Responsive font scaling
- **Preserved whitespace** - Generous spacing maintained on mobile
- **Touch-friendly navigation** - Large tap targets
- **Clean header** - Simplified mobile header with centered logo

---

## 🎯 Implementation Roadmap

### Phase 1: Foundation & Typography System

#### 1.1 Typography Implementation

**File:** `resources/css/app.css`

```css
/* Thaiconomics Typography System - Using Local Fonts */
@import './fonts.css';

:root {
  /* Typography Scale - Thaiconomics Inspired */
  --font-primary: 'Lato', system-ui, sans-serif;
  --font-serif: 'Lora', Georgia, serif;
  --font-display: 'Bitter', serif;
  --font-alt: 'Open Sans', system-ui, sans-serif;
  --font-size-xs: 12px;
  --font-size-sm: 14px;
  --font-size-base: 16px;
  --font-size-lg: 20px;
  --font-size-xl: 24px;
  --font-size-2xl: 30px;    /* Main headlines */
  --font-size-3xl: 36px;
  --font-size-4xl: 48px;
  --font-size-5xl: 55px;    /* Hero titles on single posts */
  
  /* Line Heights */
  --leading-tight: 1.2;
  --leading-normal: 1.4;
  --leading-relaxed: 1.6;
  --leading-loose: 1.8;
  
  /* Font Weights */
  --font-light: 300;
  --font-normal: 400;
  --font-bold: 700;
}

/* Typography Classes */
.font-primary { font-family: var(--font-primary); }
.text-hero { font-size: var(--font-size-5xl); font-weight: var(--font-normal); line-height: var(--leading-tight); }
.text-title { font-size: var(--font-size-2xl); font-weight: var(--font-normal); line-height: var(--leading-tight); }
.text-subtitle { font-size: var(--font-size-xl); font-weight: var(--font-normal); line-height: var(--leading-normal); }
.text-body { font-size: var(--font-size-base); font-weight: var(--font-normal); line-height: var(--leading-relaxed); }
.text-small { font-size: var(--font-size-sm); font-weight: var(--font-normal); line-height: var(--leading-normal); }
```

**File:** `tailwind.config.js`

```js
module.exports = {
  theme: {
    extend: {
      fontFamily: {
        'primary': ['"Lato"', 'system-ui', 'sans-serif'],
        'serif': ['"Lora"', 'Georgia', 'serif'],
        'display': ['"Bitter"', 'serif'],
        'alt': ['"Open Sans"', 'system-ui', 'sans-serif'],
      },
      fontSize: {
        'hero': ['55px', { lineHeight: '1.2' }],
        'title': ['30px', { lineHeight: '1.2' }],
        'subtitle': ['24px', { lineHeight: '1.4' }],
      },
    }
  }
}
```

#### 1.2 Color Palette - Minimalist Editorial

```css
:root {
  /* Thaiconomics Color System */
  --color-black: #000000;
  --color-charcoal: #333333;    /* Body text */
  --color-gray: #666666;        /* Meta text */
  --color-light-gray: #999999;  /* Subtle elements */
  --color-white: #ffffff;
  --color-off-white: #fafafa;   /* Background alternative */
  
  /* Accent colors (minimal usage) */
  --color-accent: #000000;      /* Links, CTAs */
}

/* Color Utility Classes */
.text-black { color: var(--color-black); }
.text-charcoal { color: var(--color-charcoal); }
.text-gray { color: var(--color-gray); }
.bg-white { background-color: var(--color-white); }
.bg-off-white { background-color: var(--color-off-white); }
```

#### 1.3 Spacing System - Editorial Layout

```css
:root {
  /* Thaiconomics Spacing - Generous whitespace */
  --spacing-xs: 8px;
  --spacing-sm: 16px;
  --spacing-md: 24px;
  --spacing-lg: 32px;
  --spacing-xl: 48px;
  --spacing-2xl: 64px;
  --spacing-3xl: 96px;
  --spacing-4xl: 128px;
  
  /* Editorial specific spacing */
  --spacing-section: 80px;      /* Between major sections */
  --spacing-article: 40px;      /* Between articles */
  --spacing-paragraph: 24px;    /* Between paragraphs */
}
```

---

### Phase 2: Layout & Grid System

#### 2.1 Homepage Grid Implementation

**File:** `resources/views/index.blade.php`

```php
@extends('layouts.app')

@section('content')
<!-- Hero Section: 3-Column Magazine Layout -->
<section class="py-24 bg-white">
  <div class="max-w-6xl mx-auto px-8">
    
    <!-- Top Articles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-24">
      @foreach($featured_posts->take(3) as $index => $post)
        <article class="group">
          <!-- Image -->
          <a href="{{ get_permalink($post->ID) }}" class="block mb-6">
            @if(has_post_thumbnail($post->ID))
              <img src="{{ get_the_post_thumbnail_url($post->ID, 'large') }}" 
                   alt="{{ get_the_title($post->ID) }}"
                   class="w-full h-80 object-cover">
            @endif
          </a>
          
          <!-- Meta -->
          <div class="text-sm text-gray mb-2">
            {{ get_the_date('M j', $post->ID) }}
          </div>
          
          <!-- Title -->
          <h2 class="text-title text-black mb-4 hover:text-charcoal transition-colors">
            <a href="{{ get_permalink($post->ID) }}">
              {{ get_the_title($post->ID) }}
            </a>
          </h2>
        </article>
      @endforeach
    </div>
    
    <!-- Featured Story Section -->
    @if(isset($featured_posts[3]))
      @php($featured_story = $featured_posts[3])
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
        <!-- Featured Image -->
        <div>
          @if(has_post_thumbnail($featured_story->ID))
            <img src="{{ get_the_post_thumbnail_url($featured_story->ID, 'large') }}" 
                 alt="{{ get_the_title($featured_story->ID) }}"
                 class="w-full h-96 object-cover">
          @endif
          
          <div class="mt-6">
            <div class="text-sm text-gray mb-2">
              {{ get_the_date('M j', $featured_story->ID) }}
            </div>
            <h2 class="text-title text-black">
              <a href="{{ get_permalink($featured_story->ID) }}">
                {{ get_the_title($featured_story->ID) }}
              </a>
            </h2>
          </div>
        </div>
        
        <!-- Featured Content -->
        <div class="lg:pt-8">
          <div class="text-body text-charcoal leading-relaxed">
            {{ wp_trim_words(get_the_excerpt($featured_story->ID), 50) }}
          </div>
        </div>
      </div>
    @endif
    
  </div>
</section>
@endsection
```

#### 2.2 Single Post Layout Implementation

**File:** `resources/views/single.blade.php`

```php
@extends('layouts.app')

@section('content')
<article class="py-16 bg-white">
  <div class="max-w-4xl mx-auto px-8">
    
    <!-- Hero Image -->
    @if(has_post_thumbnail())
      <div class="mb-12 text-center">
        <img src="{{ get_the_post_thumbnail_url(get_the_ID(), 'large') }}" 
             alt="{{ get_the_title() }}"
             class="w-full max-w-lg mx-auto h-80 object-cover">
      </div>
    @endif
    
    <!-- Title Section -->
    <div class="text-center mb-16">
      <h1 class="text-hero text-black mb-6 max-w-2xl mx-auto">
        {{ get_the_title() }}
      </h1>
      
      @if($subtitle = get_post_meta(get_the_ID(), 'subtitle', true))
        <h2 class="text-subtitle text-charcoal mb-8 max-w-xl mx-auto">
          {{ $subtitle }}
        </h2>
      @endif
    </div>
    
    <!-- Content Layout: Article + Sidebar -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
      
      <!-- Main Content -->
      <div class="lg:col-span-2">
        <!-- Article Content -->
        <div class="prose prose-lg max-w-none">
          <div class="text-body text-charcoal leading-relaxed space-y-6">
            {!! apply_filters('the_content', get_the_content()) !!}
          </div>
        </div>
        
        <!-- Tags -->
        @if(has_tag())
          <div class="mt-12 pt-8 border-t border-gray-200">
            <div class="text-small text-gray">
              {{ get_the_tag_list('', ', ') }}
            </div>
          </div>
        @endif
      </div>
      
      <!-- Sidebar -->
      <div class="lg:col-span-1">
        <!-- Subscribe Box -->
        <div class="bg-off-white p-8 mb-8">
          <h3 class="text-title text-black mb-6">Subscribe</h3>
          <form class="space-y-4">
            <input type="email" 
                   placeholder="your email address"
                   class="w-full px-4 py-3 border border-gray-300 text-sm focus:outline-none focus:border-black">
            <button type="submit" 
                    class="w-full bg-black text-white px-4 py-3 text-sm hover:bg-charcoal transition-colors">
              Signup
            </button>
          </form>
        </div>
        
        <!-- Author Box -->
        @if($author_name = get_the_author())
          <div class="bg-off-white p-8">
            <h3 class="text-lg text-black mb-4">{{ $author_name }}</h3>
            
            @if($author_bio = get_the_author_meta('description'))
              <div class="text-small text-gray mb-4">
                {{ $author_bio }}
              </div>
            @endif
            
            @if($author_location = get_the_author_meta('location'))
              <div class="text-small text-charcoal">
                {{ $author_location }}
              </div>
            @endif
          </div>
        @endif
      </div>
      
    </div>
  </div>
</article>
@endsection
```

---

### Phase 3: Header & Navigation

#### 3.1 Minimal Header Implementation

**File:** `resources/views/sections/header.blade.php`

```php
<header class="bg-white border-b border-gray-100">
  <div class="max-w-6xl mx-auto px-8">
    <div class="flex items-center justify-between py-8">
      
      <!-- Mobile Menu Toggle -->
      <button class="md:hidden text-black">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
      
      <!-- Logo/Brand -->
      <div class="flex-1 text-center">
        <h1 class="text-xl text-black font-normal">
          <a href="{{ home_url('/') }}" class="hover:text-charcoal transition-colors">
            {{ get_bloginfo('name') }}
          </a>
        </h1>
        <div class="w-16 h-px bg-black mx-auto mt-2"></div>
      </div>
      
      <!-- Social Links -->
      <div class="hidden md:flex items-center space-x-4">
        <a href="#" class="text-black hover:text-charcoal transition-colors">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <!-- Facebook icon -->
          </svg>
        </a>
        <a href="#" class="text-black hover:text-charcoal transition-colors">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <!-- Twitter icon -->
          </svg>
        </a>
        <a href="#" class="text-black hover:text-charcoal transition-colors">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <!-- Instagram icon -->
          </svg>
        </a>
      </div>
    </div>
  </div>
</header>
```

#### 3.2 Simple Footer Navigation

**File:** `resources/views/sections/footer.blade.php`

```php
<footer class="bg-white border-t border-gray-100">
  <div class="max-w-6xl mx-auto px-8 py-12">
    
    <!-- Simple Footer Navigation -->
    <nav class="text-center">
      <ul class="flex items-center justify-center space-x-8 text-sm text-charcoal">
        <li><a href="/about" class="hover:text-black transition-colors">About</a></li>
        <li><a href="/work" class="hover:text-black transition-colors">Work</a></li>
        <li><a href="/contact" class="hover:text-black transition-colors">Contact</a></li>
      </ul>
    </nav>
    
    <!-- Copyright -->
    <div class="text-center mt-8 text-sm text-gray">
      <p>&copy; {{ date('Y') }} {{ get_bloginfo('name') }}. All rights reserved.</p>
    </div>
    
  </div>
</footer>
```

---

### Phase 4: View Composer Updates

#### 4.1 Index View Composer Enhancement

**File:** `app/View/Composers/Index.php`

```php
<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Index extends Composer
{
    protected static $views = ['index'];

    public function with()
    {
        return [
            'featured_posts' => $this->featuredPosts(),
            'site_title' => get_bloginfo('name'),
        ];
    }

    protected function featuredPosts()
    {
        // Get posts with featured images for magazine layout
        return get_posts([
            'numberposts' => 6,
            'post_status' => 'publish',
            'meta_key' => '_thumbnail_id', // Only posts with featured images
            'orderby' => 'date',
            'order' => 'DESC'
        ]);
    }
}
```

#### 4.2 Single Post View Composer

**File:** `app/View/Composers/Post.php`

```php
<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Post extends Composer
{
    protected static $views = ['single'];

    public function with()
    {
        return [
            'subtitle' => $this->getSubtitle(),
            'author_info' => $this->getAuthorInfo(),
            'related_posts' => $this->getRelatedPosts(),
        ];
    }

    protected function getSubtitle()
    {
        // Get custom subtitle field or generate from excerpt
        $subtitle = get_post_meta(get_the_ID(), 'subtitle', true);
        
        if (empty($subtitle)) {
            $subtitle = wp_trim_words(get_the_excerpt(), 20);
        }
        
        return $subtitle;
    }

    protected function getAuthorInfo()
    {
        return [
            'name' => get_the_author(),
            'bio' => get_the_author_meta('description'),
            'location' => get_the_author_meta('location') ?: 'Author Location',
            'avatar' => get_avatar_url(get_the_author_meta('ID')),
        ];
    }

    protected function getRelatedPosts()
    {
        $tags = wp_get_post_tags(get_the_ID());
        
        if (empty($tags)) {
            return [];
        }
        
        $tag_ids = wp_list_pluck($tags, 'term_id');
        
        return get_posts([
            'numberposts' => 3,
            'post_status' => 'publish',
            'post__not_in' => [get_the_ID()],
            'tag__in' => $tag_ids,
            'meta_key' => '_thumbnail_id'
        ]);
    }
}
```

---

### Phase 5: Responsive Design & Mobile Experience

#### 5.1 Mobile-First Responsive Implementation

Based on the mobile screenshot analysis, here's the responsive CSS implementation:

```css
/* Mobile-first responsive design - Thaiconomics inspired */

/* Base mobile styles (320px+) */
.text-hero { font-size: 28px; line-height: 1.2; }
.text-title { font-size: 20px; line-height: 1.3; }
.text-subtitle { font-size: 18px; line-height: 1.4; }

/* Mobile grid - single column layout */
.grid { grid-template-columns: 1fr; gap: 24px; }
.py-24 { padding-top: 32px; padding-bottom: 32px; }
.px-8 { padding-left: 16px; padding-right: 16px; }
.gap-12 { gap: 16px; }

/* Mobile header adjustments */
.mobile-header {
  padding: 16px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.mobile-menu-toggle {
  display: block;
  width: 24px;
  height: 24px;
}

/* Mobile images - full width */
.mobile-image {
  width: 100%;
  height: auto;
  margin-bottom: 24px;
}

/* Small mobile devices (up to 480px) */
@media (max-width: 480px) {
  .text-hero { font-size: 24px; }
  .text-title { font-size: 18px; }
  .px-8 { padding-left: 12px; padding-right: 12px; }
}

/* Tablet breakpoint (481px - 768px) */
@media (min-width: 481px) and (max-width: 768px) {
  .text-hero { font-size: 32px; }
  .text-title { font-size: 22px; }
  .py-24 { padding-top: 40px; padding-bottom: 40px; }
}

/* Small desktop breakpoint (769px - 1024px) */
@media (min-width: 769px) and (max-width: 1024px) {
  .text-hero { font-size: 48px; }
  .text-title { font-size: 28px; }
  
  /* Tablet grid - 2 columns for some sections */
  .md\:grid-cols-3 { grid-template-columns: repeat(2, 1fr); }
}

/* Desktop breakpoint (1025px+) */
@media (min-width: 1025px) {
  .text-hero { font-size: 55px; }
  .text-title { font-size: 30px; }
  
  /* Full desktop grid */
  .md\:grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
  .lg\:grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
  
  /* Desktop spacing */
  .py-24 { padding-top: 96px; padding-bottom: 96px; }
  .gap-12 { gap: 48px; }
  .px-8 { padding-left: 32px; padding-right: 32px; }
}

/* Mobile navigation - hidden desktop elements */
@media (max-width: 768px) {
  .desktop-social { display: none; }
  .mobile-menu-toggle { display: block; }
}

@media (min-width: 769px) {
  .mobile-menu-toggle { display: none; }
  .desktop-social { display: flex; }
}
```

#### 5.2 Mobile-Specific Template Adjustments

**Mobile Header Implementation:**

```php
<!-- Mobile-optimized header -->
<header class="bg-white border-b border-gray-100">
  <div class="max-w-8xl mx-auto px-4 sm:px-8">
    <div class="mobile-header">
      
      <!-- Mobile Menu Toggle -->
      <button class="mobile-menu-toggle md:hidden text-black" aria-label="Menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
      
      <!-- Centered Logo -->
      <div class="flex-1 text-center">
        <h1 class="text-lg sm:text-xl text-black font-normal">
          <a href="{{ home_url('/') }}" class="hover:text-charcoal transition-colors">
            {{ get_bloginfo('name') }}
          </a>
        </h1>
      </div>
      
      <!-- Desktop Social Links -->
      <div class="desktop-social hidden md:flex items-center space-x-4">
        <!-- Social icons -->
      </div>
      
      <!-- Mobile spacer -->
      <div class="w-6 h-6 md:hidden"></div>
    </div>
  </div>
</header>
```

**Mobile Homepage Grid:**

```php
<!-- Mobile-responsive homepage layout -->
<section class="py-16 sm:py-24 bg-white">
  <div class="max-w-8xl mx-auto px-4 sm:px-8">
    
    <!-- Mobile: Single column, Desktop: 3 columns -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-12 mb-16 sm:mb-24">
      @foreach($featured_posts->take(3) as $post)
        <article class="group">
          <!-- Mobile-optimized image -->
          <a href="{{ get_permalink($post->ID) }}" class="block mb-4 sm:mb-6">
            @if(has_post_thumbnail($post->ID))
              <img src="{{ get_the_post_thumbnail_url($post->ID, 'large') }}" 
                   alt="{{ get_the_title($post->ID) }}"
                   class="mobile-image sm:w-full sm:h-80 object-cover">
            @endif
          </a>
          
          <!-- Mobile-friendly typography -->
          <div class="text-xs sm:text-sm text-gray mb-2">
            {{ get_the_date('M j', $post->ID) }}
          </div>
          
          <h2 class="text-lg sm:text-title text-black mb-4 hover:text-charcoal transition-colors leading-tight">
            <a href="{{ get_permalink($post->ID) }}">
              {{ get_the_title($post->ID) }}
            </a>
          </h2>
        </article>
      @endforeach
    </div>
    
  </div>
</section>
```

---

## 🎯 Implementation Priority

### Phase 1: Foundation (Week 1)
1. ✅ Typography system implementation
2. ✅ Color palette setup  
3. ✅ Spacing system configuration

### Phase 2: Layout (Week 2)
1. ✅ Homepage grid implementation
2. ✅ Single post layout redesign
3. ✅ View Composer updates

### Phase 3: Components (Week 3)
1. ✅ Header/navigation redesign
2. ✅ Footer simplification
3. ✅ Sidebar components (subscribe, author)

### Phase 4: Polish (Week 4)
1. ✅ Mobile responsiveness
2. ✅ Image optimization
3. ✅ Performance optimization

---

## 📊 Expected Results

After implementing this Thaiconomics-inspired design:

- ✨ **Clean, editorial aesthetic** with sophisticated typography
- 📰 **Magazine-style layout** with asymmetric grid design
- 🎨 **Minimalist color palette** focusing on readability
- 📱 **Excellent mobile experience** with mobile-first approach
- ⚡ **Fast loading times** with minimal CSS and optimized images
- 📖 **Enhanced reading experience** with proper typography hierarchy

---

## 🔧 Key Differences from Previous Design

| Aspect | Previous (Clarity) | New (Thaiconomics) |
|--------|-------------------|-------------------|
| **Color Scheme** | Colorful, gradients | Black, white, minimal |
| **Typography** | Inter, multiple weights | Lato/Lora/Bitter, editorial |
| **Layout** | Card-based grid | Editorial magazine style |
| **Navigation** | Complex dropdown | Simple horizontal links |
| **Images** | Rounded corners | Clean, rectangular |
| **Spacing** | Compact | Generous whitespace |
| **Style** | Modern web app | Classic editorial |

---

## 📚 Technical Notes

### CSS Variables Structure
The theme uses **two complementary CSS variable systems**:

**WordPress Preset Variables (316 total):**
- **248 color entries** defined in `theme.json` (complete Tailwind palette)
- **68 WordPress preset variables** auto-generated (aspect ratios, gradients, shadows, spacing, legacy colors)
- Format: `--wp--preset--*` (e.g., `--wp--preset--color--red-500`, `--wp--preset--font-family--lato`)
- Generated automatically from `theme.json` + WordPress core defaults

**Custom Theme Variables (in `resources/css/app.css`):**
- **Editorial design tokens**: `--color-black`, `--color-charcoal`, `--font-size-hero`
- **Typography scale**: Custom sizes like `--font-size-xx-large` (55px desktop, 28px mobile)
- **Spacing system**: Editorial spacing from `--spacing-xs` (8px) to `--spacing-5xl` (160px)
- **Layout variables**: `--content-width-narrow` (65ch), `--sidebar-width` (320px)
- **Animation/interaction**: `--transition-fast`, `--focus-ring`
- Used for theme-specific design tokens not covered by WordPress presets

### Custom CSS Variables Usage
All design tokens are stored as CSS custom properties for easy maintenance and theming.

### Tailwind Integration
The design uses Tailwind utilities but extends it with custom classes for editorial-specific styling.

### WordPress Integration
- Custom post meta fields for subtitles
- Enhanced author profiles with location
- Featured image requirements for proper layout
- SEO-optimized structure

### Performance Considerations
- Minimal CSS footprint
- Optimized font loading
- Progressive image enhancement
- Mobile-first responsive design

---

*Design system updated on September 10, 2025 - Inspired by Thaiconomics minimalist editorial design at https://thaiconomics.smtv.test*