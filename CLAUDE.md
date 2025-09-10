# CLAUDE.md

This file provides guidance to Clau### File Structure

### PHP Architecture
- `functions.php` - Main theme entry point, bootstraps Acorn and includes app files

#### The `app/` Directory
The `app/` directory contains all theme functionality and is namespaced under `App\`:

- **`app/setup.php`** — Theme setup: enqueue assets, register theme features, navigation menus, sidebars
- **`app/filters.php`** — WordPress filters (e.g., excerpt_more filter)  
- **`app/Providers/`** — Service Providers for theme functionality (extends Sage's base provider)
- **`app/View/Composers/`** — View Composers for passing data to Blade templates (preferred over inline PHP)

The majority of theme functionality lives in the `app/` directory. All classes follow PSR-4 autoloading under the `App\` namespace.

Most PHP code in Sage is namespaced and autoloaded. All theme functionality should use namespaced functions and classes following Laravel patterns:

**Key App Directory Responsibilities:**
- **`app/setup.php`** — Enqueue stylesheets and scripts, register support for theme features with `add_theme_support`, register navigation menus and sidebars
- **`app/filters.php`** — Add WordPress filters (e.g., `excerpt_more` filter for "... Continued" text)
- **`app/Providers/`** — Service Providers for theme functionality (extends `Roots\Acorn\ServiceProvider`)
- **`app/View/Composers/`** — View Composers and Components for passing data to Blade templates (preferred over inline `@php` blocks)

## View Composers: The Sage Way

View Composers are the cornerstone of data handling in Sage themes. They separate data logic from presentation, following Laravel's architectural patterns.

### Why Use View Composers?
- **Separation of Concerns**: Keep data fetching logic out of Blade templates
- **Reusability**: Share data logic across multiple templates
- **Testability**: Easier to unit test data logic separately
- **Performance**: Centralized data fetching and caching
- **Maintainability**: Changes to data logic don't require template modifications

### Creating View Composers
Use the Artisan command to generate new View Composers:
```bash
wp acorn make:composer ExampleComposer  # Creates app/View/Composers/ExampleComposer.php
wp acorn make:composer HeroSection      # Creates app/View/Composers/HeroSection.php
```

### View Composer Structure
```php
// app/View/Composers/Index.php
<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Index extends Composer
{
    protected static $views = ['index', 'partials.hero-section'];

    public function with()
    {
        return [
            'featured_posts' => $this->featuredPosts(),
            'latest_posts' => $this->latestPosts(),
            'categories' => $this->categories(),
            'category_colors' => $this->categoryColors()
        ];
    }

    protected function featuredPosts()
    {
        return get_posts([
            'numberposts' => 3,
            'post_status' => 'publish',
            'meta_key' => '_thumbnail_id'
        ]);
    }

    protected function categoryColors()
    {
        return [
            'Technology' => ['text' => 'text-blue-600', 'bg' => 'bg-blue-50'],
            'Travel' => ['text' => 'text-green-600', 'bg' => 'bg-green-50'],
            'Lifestyle' => ['text' => 'text-purple-600', 'bg' => 'bg-purple-50'],
        ];
    }
}
```

### Template Usage
With View Composers, Blade templates become clean and focused:
```php
{{-- resources/views/partials/hero-section.blade.php --}}
@if (!empty($featured_posts))
  <section class="py-16 bg-gray-50">
    {{-- Clean template using data from View Composer --}}
    @foreach($featured_posts as $post)
      <article>{{ get_the_title($post->ID) }}</article>
    @endforeach
  </section>
@endif
```

### Anti-Pattern: Avoid Inline PHP
```php
{{-- ❌ WRONG - Don't do this --}}
@php
  $featured_posts = get_posts(['numberposts' => 3]);
  $categories = get_categories();
@endphp

{{-- ✅ CORRECT - Use View Composer data --}}
@foreach($featured_posts as $post)
  {{-- Template logic only --}}
@endforeach
```(claude.ai/code) when working with code in this repository.

## Architecture Overview

This is a **Sage WordPress theme** built on Laravel's Acorn framework, combining modern Laravel patterns with WordPress theme development. The theme uses:

- **Laravel Blade templates** for PHP templating (instead of traditional PHP template files)
- **Roots Acorn** as the Laravel framework integration for WordPress
- **Vite** for modern frontend build tooling and asset compilation
- **Tailwind CSS** for utility-first styling
- **PSR-4 autoloading** with Composer for PHP classes

### Key Architecture Components

- **App namespace**: All PHP classes use the `App\` namespace with PSR-4 autoloading
- **Service Provider pattern**: `App\Providers\ThemeServiceProvider` extends Sage's base provider
- **View Composers**: Located in `app/View/Composers/` for passing data to Blade templates
- **Blade templates**: All views are in `resources/views/` with `.blade.php` extension
- **Asset compilation**: Vite compiles assets from `resources/` to `public/build/`

## Development Commands

### Frontend Development
```bash
npm run dev          # Start Vite development server with hot reload
npm run build        # Build production assets
```

### Code Quality
```bash
./vendor/bin/pint    # Run Laravel Pint code formatter (PHP)
```

### Translation/Internationalization
```bash
npm run translate           # Generate .pot file and update .po files
npm run translate:pot       # Generate .pot file only
npm run translate:update    # Update .po files from .pot
npm run translate:compile   # Compile .po to .mo and JSON files
```

### Site Comparison & Testing
```bash
node compare-sites.js       # Run Playwright script to compare thyra.test with reference site
```

### Local Development SSL
For local development using Laravel Valet or similar tools, the local site uses self-signed SSL certificates. When testing with curl:
```bash
curl -i http://thyra.test   # Use HTTP instead of HTTPS for local development
curl -i -k https://thyra.test # Or use -k flag to ignore SSL certificate errors
```

The `compare-sites.js` script uses Playwright to:
- Take full-page screenshots of both the local thyra.test site and the reference clarity-tailwind.preview.uideck.com
- Extract and compare page structure, navigation, sections, and styling
- Generate detailed JSON reports and HTML content exports
- Highlight key differences between implementations
- Save outputs as: `online-version.png`, `local-version.png`, `online-structure.json`, `local-structure.json`, `online-content.html`, `local-content.html`

This is particularly useful for analyzing layout differences, hero section implementations, and ensuring visual consistency with the design reference.

### Prerequisites
- **Node.js**: >=20.0.0 (specified in package.json engines)
- **PHP**: >=8.2 (required by Acorn)
- **Composer**: Required for PHP dependencies

## File Structure

### PHP Architecture
- `functions.php` - Main theme entry point, bootstraps Acorn and includes app files
- `app/setup.php` - Theme setup functions (nav menus, theme supports, etc.)
- `app/filters.php` - WordPress filters and hooks
- `app/Providers/` - Laravel service providers
- `app/View/Composers/` - Blade view composers for data injection

#### The `resources/` Directory
Contains Blade views and un-compiled assets (CSS, JavaScript, images, fonts):

- **`resources/views/`** — All Blade templates (`.blade.php` files)
- **`resources/css/app.css`** — Main application styles
- **`resources/css/editor.css`** — Block editor styles  
- **`resources/js/app.js`** — Main JavaScript entry point
- **`resources/js/editor.js`** — Block editor JavaScript
- **`resources/images/`** — Image assets
- **`resources/fonts/`** — Font files

#### The `public/` Directory
Contains compiled assets (auto-generated, never manually modified):

- **`public/build/`** — Compiled assets from Vite build process

#### Other Important Directories
- **`vendor/`** — Composer dependencies and autoloader (auto-generated)
- **`node_modules/`** — Node.js dependencies for build process (auto-generated, **never upload to production**)

### Build Configuration
- `vite.config.js` - Vite configuration with Tailwind, Laravel plugin, and WordPress integration
- `theme.json` - WordPress theme.json (gets compiled to `public/build/assets/theme.json`)

## Font Management

Sage provides a structured approach to adding custom fonts to your theme:

### Adding Custom Fonts

1. **Add font files** to `resources/fonts/` directory (use `.woff2` format for best browser support)
2. **Create fonts.css** file at `resources/css/fonts.css`
3. **Import fonts.css** in both `app.css` and `editor.css`:
   ```css
   @import './fonts.css';
   ```

### Font CSS Structure

**File:** `resources/css/fonts.css`

```css
@font-face {
  font-display: swap;
  font-family: 'Helvetica Neue';
  font-style: normal;
  font-weight: 400;
  src: url('@fonts/helvetica-neue-regular.woff2') format('woff2');
}

@font-face {
  font-display: swap;
  font-family: 'Helvetica Neue';
  font-style: normal;
  font-weight: 700;
  src: url('@fonts/helvetica-neue-bold.woff2') format('woff2');
}
```

### Tailwind CSS Integration

Add custom fonts to your Tailwind theme in `resources/css/app.css`:

```css
@theme {
  --font-primary: "Helvetica Neue", Helvetica, Arial, sans-serif;
}
```

### Font Resources

- **Google Fonts Helper**: [google-webfonts-helper.herokuapp.com](https://google-webfonts-helper.herokuapp.com/) - Easy way to download font files and generate CSS
- **Font Display**: Use `font-display: swap` for better loading performance
- **Format Priority**: `.woff2` has excellent browser support and should be your primary format

## WordPress Integration

### Theme.json Workflow
The theme uses a preprocessed `theme.json` that gets compiled by Vite to include Tailwind's design tokens. The built version is loaded via the `theme_file_path` filter in `app/setup.php:54`.

### Block Editor Integration
- Editor styles are injected via `block_editor_settings_all` filter
- Editor JavaScript dependencies are managed through Vite's manifest system
- Full-site editing is disabled (`remove_theme_support('block-templates')`)

### ACF Block Development with ACF Composer
For creating rigid, admin-controlled blocks that customers should not customize extensively:

**Installation:**
```bash
composer require log1x/acf-composer
```

**Creating ACF Blocks:**
```bash
wp acorn make:block HeroSection     # Creates app/Blocks/HeroSection.php
wp acorn make:field HeroSection     # Creates app/Fields/HeroSection.php (optional)
```

**ACF Composer Block Structure:**
```php
// app/Blocks/HeroSection.php
<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use Log1x\AcfComposer\Builder;

class HeroSection extends Block
{
    public $name = 'Hero Section';
    public $description = 'A rigid hero section block for editorial content.';
    public $category = 'theme';
    public $icon = 'cover-image';
    public $keywords = ['hero', 'banner', 'featured'];
    public $supports = [
        'align' => false,
        'mode' => false,
        'jsx' => true,
    ];

    public function fields()
    {
        $heroSection = Builder::make('hero_section');

        $heroSection
            ->addText('headline', ['label' => 'Headline'])
            ->addTextarea('subheadline', ['label' => 'Subheadline'])
            ->addImage('background_image', ['label' => 'Background Image']);

        return $heroSection->build();
    }
}
```

**Block Template Structure:**
```php
{{-- resources/views/blocks/hero-section.blade.php --}}
<section class="hero-section bg-cover bg-center" style="background-image: url('{{ $background_image['url'] ?? '' }}')">
  <div class="hero-content">
    <h1 class="hero-headline">{{ $headline }}</h1>
    <p class="hero-subheadline">{{ $subheadline }}</p>
  </div>
</section>
```

### Native Block Development with Sage Native Block
For creating flexible, customer-editable blocks using JS/React:

**Installation:**
```bash
composer require imagewize/sage-native-block --dev
```

**Creating Native Blocks:**
```bash
wp acorn native-block:make CustomButton    # Creates JS/React block scaffolding
```

**Block Registration:**
Native blocks are registered in `resources/js/blocks/` and compiled through Vite. These blocks are fully editable in the browser like WordPress native blocks.

**⚠️ Important Limitation:**
Use Sage Native Block only for blocks that need full editor flexibility **without CSS flex ordering conflicts**. If your CSS uses `flex` with `order` properties to rearrange layouts, editor changes can conflict with the styling. For layouts that rely on CSS flex ordering, use ACF Blocks instead for better control.

### Asset Loading
Assets are loaded through Laravel's Vite integration, with manifest-based dependency management for optimal performance.

### WordPress Features
- Navigation menus registered (primary_navigation)
- Standard WordPress theme supports enabled (post-thumbnails, html5, etc.)
- Two widget areas: sidebar-primary and sidebar-footer
- Core block patterns disabled in favor of custom implementation

## Common Issues & Troubleshooting

### Blade Template Syntax Errors
The most common issue when working with Blade templates in this Sage theme:

**Problem**: `ParseError: syntax error, unexpected token "endforeach", expecting "elseif" or "else" or "endif"`

**Root Cause**: Incorrect `@php` directive syntax that breaks the Blade compiler

```php
// ❌ WRONG - This causes compilation errors:
@php($main_post = $featured_posts[0])        // Missing semicolon in single-line syntax
@php(
  $variable = 'value';                       // Parentheses syntax with multi-line code
  $array = ['item1', 'item2'];
)

// ✅ CORRECT - Proper Blade @php syntax:
@php($main_post = $featured_posts[0])        // Single-line: use parentheses WITHOUT semicolon
@php
  $variable = 'value';                       // Multi-line: use @php/@endphp blocks
  $array = ['item1', 'item2'];
@endphp
```

**Complete Solution Process**: 
1. **Fix syntax**: Use `@php` and `@endphp` for multi-line PHP blocks
2. **Single-line assignments**: Use `@php($variable = 'value')` WITHOUT trailing semicolon
3. **Clear view cache**: `wp acorn view:clear` or `wp acorn optimize:clear`
4. **Force cache regeneration**: `rm -rf wp-content/cache/acorn/framework/views/*`
5. **Debug compilation**: Check compiled views in `wp-content/cache/acorn/framework/views/` for syntax errors
6. **Test immediately**: Visit site in browser or use `curl -i http://thyra.test` to verify fix

**Critical Notes**:
- Blade compilation errors can persist even after fixing the source file due to cached compiled views
- Always clear cache after fixing Blade syntax errors
- The error message may point to `endforeach` or `endif` but the actual issue is usually malformed `@php` directives earlier in the template
- Use HTTP (`curl -i http://thyra.test`) instead of HTTPS for local development to avoid SSL certificate warnings

## Blade Layouts & Template Architecture

Sage uses Laravel's Blade templating engine with a layout-based architecture for clean template organization.

### Layout Structure
```php
// resources/views/layouts/app.blade.php
<html>
  <body>
    <header>
      @section('header')
        @include('partials.nav.primary')
      @show
    </header>
    <main>
      @yield('content')
    </main>
    <footer>
      @yield('footer')
    </footer>
  </body>
</html>
```

### Extending Layouts
Template files extend the base layout and define content for specific sections:
```php
// resources/views/index.blade.php
@extends('layouts.app')

@section('header')
  @parent                    {{-- Include parent section content --}}
  @include('partials.breadcrumbs')
@endsection

@section('content')
  @include('partials.hero-section')
  
  <div class="container">
    {{-- Page-specific content --}}
  </div>
@endsection
```

### Including Partials
Break templates into reusable components using `@include`:
```php
{{-- Include with data from View Composer --}}
@include('partials.hero-section')

{{-- Include with explicit data --}}
@include('partials.post-card', ['post' => $featured_post])

{{-- Conditional includes --}}
@includeWhen(!empty($featured_posts), 'partials.hero-section')
```

### Key Blade Directives
- **`@extends('layout')`** - Specify which layout to use
- **`@section('name')`** - Define content for a layout section
- **`@yield('name')`** - Output content from a section
- **`@parent`** - Include parent section content when overriding
- **`@include('partial')`** - Include another Blade template

### Cache Management
- **Clear all caches**: `wp acorn optimize:clear`
- **Clear view cache only**: `wp acorn view:clear`
- **Compile views**: `wp acorn view:cache` (useful for debugging syntax)