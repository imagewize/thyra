# CLAUDE.md

This file provides guidance to Claude Code when working with code in this repository.

## Table of Contents

- [Architecture Overview](#architecture-overview)
- [File Structure](#file-structure)
  - [PHP Architecture](#php-architecture)
  - [The `app/` Directory](#the-app-directory)
  - [The `resources/` Directory](#the-resources-directory)
  - [The `public/` Directory](#the-public-directory)
  - [Other Important Directories](#other-important-directories)
- [View Composers: The Sage Way](#view-composers-the-sage-way)
  - [Why Use View Composers?](#why-use-view-composers)
  - [Creating View Composers](#creating-view-composers)
  - [View Composer Structure](#view-composer-structure)
  - [Template Usage](#template-usage)
  - [Anti-Pattern: Avoid Inline PHP](#anti-pattern-avoid-inline-php)
- [Development Commands](#development-commands)
  - [Frontend Development](#frontend-development)
  - [Code Quality](#code-quality)
  - [Image Size Testing](#image-size-testing)
  - [Translation/Internationalization](#translationinternationalization)
  - [Site Comparison & Testing](#site-comparison--testing)
  - [Local Development SSL](#local-development-ssl)
- [Font Management](#font-management)
  - [Adding Custom Fonts](#adding-custom-fonts)
  - [Font CSS Structure](#font-css-structure)
  - [Tailwind CSS Integration](#tailwind-css-integration)
  - [Font Resources](#font-resources)
- [WordPress Integration](#wordpress-integration)
  - [Theme.json Workflow](#themejson-workflow)
  - [Block Editor Integration](#block-editor-integration)
  - [ACF Block Development with ACF Composer](#acf-block-development-with-acf-composer)
  - [Native Block Development with Sage Native Block](#native-block-development-with-sage-native-block-primary-approach)
  - [Asset Loading](#asset-loading)
  - [WordPress Features](#wordpress-features)
- [Blade Layouts & Template Architecture](#blade-layouts--template-architecture)
  - [Layout Structure](#layout-structure)
  - [Extending Layouts](#extending-layouts)
  - [Including Partials](#including-partials)
  - [Key Blade Directives](#key-blade-directives)
  - [Cache Management](#cache-management)
- [Common Issues & Troubleshooting](#common-issues--troubleshooting)
  - [Blade Template Syntax Errors](#blade-template-syntax-errors)

## File Structure

### PHP Architecture
- `functions.php` - Main theme entry point, bootstraps Acorn and includes app files

#### The `app/` Directory
The `app/` directory contains all theme functionality and is namespaced under `App\`:

- **`app/setup.php`** — Theme setup: enqueue assets, register theme features, navigation menus, sidebars
- **`app/filters.php`** — WordPress filters (e.g., excerpt_more filter)  
- **`app/Providers/`** — Service Providers for theme functionality (extends Sage's base provider)
- **`app/View/Composers/`** — View Composers for passing data to Blade templates (preferred over inline PHP)

Most PHP code in Sage is namespaced and autoloaded. All theme functionality should use namespaced functions and classes following Laravel patterns:

**Key App Directory Responsibilities:**
- **`app/setup.php`** — Enqueue stylesheets and scripts, register support for theme features with `add_theme_support`, register navigation menus and sidebars
- **`app/Providers/`** — Service Providers for theme functionality (extends `Roots\Acorn\ServiceProvider`)
- **`app/View/Composers/`** — View Composers and Components for passing data to Blade templates (preferred over inline `@php` blocks)

## View Composers: The Sage Way

**View Composers are the cornerstone of Sage architecture** - they separate data logic from presentation and enable clean, maintainable templates.

### Why Use View Composers?
- **Separation of Concerns**: Keep data fetching logic out of Blade templates
- **Reusability**: Share data logic across multiple templates  
- **Testability**: Easier to unit test data logic separately
- **Performance**: Centralized data fetching and caching
- **Laravel Patterns**: Follow established Laravel/Sage architectural patterns

### Creating View Composers
Use the Artisan command to generate new View Composers:
```bash
wp acorn make:composer HeroSection      # Creates app/View/Composers/HeroSection.php
```

### Automatic View Binding
Sage automatically binds Composers to views based on file paths:
- View: `/resources/views/partials/hero-section.blade.php`
- Composer: `/app/View/Composers/HeroSection.php`
- **Auto-matched**: Convert `kebab-case` view names to `PascalCase` Composer names

### View Composer Structure
```php
// app/View/Composers/Index.php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

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

### `with()` vs `override()` Methods
- **`with()`**: Adds data without overriding inherited/passed data
- **`override()`**: Replaces any existing data with the same key names
- **Use `with()`** for most cases to preserve data inheritance

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

### Blade Template Management
```bash
wp acorn view:cache  # Compile all Blade templates (useful for debugging)
wp acorn view:clear  # Clear all compiled Blade templates
wp acorn optimize:clear  # Clear all caches (views, config, routes)
```

### Component & Composer Generation
```bash
wp acorn make:composer ExampleComposer    # Create new View Composer
wp acorn make:component ExampleComponent  # Create new Blade Component
```

### Image Size Testing
```bash
wp media regenerate --all          # Regenerate all image sizes for existing images
wp media regenerate [attachment-id] # Regenerate sizes for specific image
wp eval "print_r(get_intermediate_image_sizes());"  # List all registered image sizes
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

### Local Development SSL & MIME Types
For local development using Laravel Valet or similar tools, the local site uses self-signed SSL certificates. When testing with curl:
```bash
curl -i http://thyra.test   # Use HTTP instead of HTTPS for local development
curl -i -k https://thyra.test # Or use -k flag to ignore SSL certificate errors
```

**Font Loading Issues**: If you see Chrome errors like `Failed to decode downloaded font` or `OTS parsing error: invalid sfntVersion`, this is typically an nginx MIME type configuration issue. Laravel Valet/nginx may not be serving WOFF2 files with the correct `font/woff2` MIME type, causing browsers to reject otherwise valid font files.

**Solution**: Add WOFF2 MIME type to your nginx configuration:
```nginx
# In nginx.conf or valet configuration
location ~* \.(woff2)$ {
    add_header Content-Type font/woff2;
    expires 1y;
    add_header Cache-Control "public, immutable";
}
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
/* Lato - Primary Sans Serif Font */
@font-face {
  font-display: swap;
  font-family: 'Lato';
  font-style: normal;
  font-weight: 400;
  src: url('@fonts/lato-regular.woff2') format('woff2');
}

/* Bitter - Display Font (Variable) */
@font-face {
  font-display: swap;
  font-family: 'Bitter';
  font-style: normal;
  font-weight: 100 900;
  src: url('@fonts/bitter-variable-font.woff2') format('woff2-variations');
}

/* Menlo - Mono Font */
@font-face {
  font-display: swap;
  font-family: 'Menlo';
  font-style: normal;
  font-weight: 400;
  src: url('@fonts/menlo-regular-webfont.woff2') format('woff2');
}
```

### Tailwind CSS Integration

Add custom fonts to your Tailwind theme in `resources/css/app.css`:

```css
@theme {
  /* Editorial Typography System - Three Font Hierarchy */
  --font-heading: "Bitter", serif;
  --font-intro: "Bitter", serif;  
  --font-body: "Lato", system-ui, sans-serif;

  /* Tailwind font family mappings */
  --font-sans: "Lato", system-ui, sans-serif;
  --font-serif: "Bitter", serif;
  --font-mono: "Menlo", ui-monospace, SFMono-Regular, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
}
```

### Font Resources

- **Google Webfonts Helper**: [gwfh.mranftl.com](https://gwfh.mranftl.com/) - Easy way to download font files and generate CSS
- **API Downloads**: Use the API for bulk downloads: `https://gwfh.mranftl.com/api/fonts/{font-name}?download=zip&subsets=latin&variants=regular,300,700,900&formats=woff2`
  - Example: `https://gwfh.mranftl.com/api/fonts/lato?download=zip&subsets=latin&variants=300,700,900,regular,italic&formats=woff2`
- **Font Display**: Use `font-display: swap` for better loading performance
- **Format Priority**: `.woff2` has excellent browser support and should be your primary format

## WordPress Integration

### Theme.json Workflow
The theme uses a preprocessed `theme.json` that gets compiled by Vite to include Tailwind's design tokens. The built version is loaded via the `theme_file_path` filter in `app/setup.php:54`.

### Block Editor Integration
- Editor styles are injected via `block_editor_settings_all` filter
- Editor JavaScript dependencies are managed through Vite's manifest system
- Full-site editing is disabled (`remove_theme_support('block-templates')`)

### ACF Block Development with ACF Composer (USE ONLY WHEN NECESSARY)
For exceptional cases where native blocks cannot meet requirements:

**⚠️ Note**: This approach should only be used when native blocks are insufficient. Use only when:
- You need extremely rigid, admin-only control over content structure
- Complex server-side rendering requirements that cannot be handled client-side
- Legacy compatibility requirements

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

### Native Block Development with Sage Native Block (PRIMARY APPROACH)
This theme uses native WordPress blocks as the primary block development approach for maximum flexibility and modern development patterns.

**Installation:**
```bash
composer require imagewize/sage-native-block --dev
```

**Recommended Workflow:**
1. **Create Pattern in Editor**: Use WordPress block editor to create a pattern/layout as base
2. **Copy to Claude**: Copy the pattern HTML/structure for reference  
3. **Generate Native Block**: Use Claude to create block with:
   ```bash
   wp acorn sage-native-block:add-setup imagewize/my-cool-block
   ```
4. **Adjust Block**: Claude adapts the pattern into the native block structure

**Why This Approach:**
- **Faster Development**: No need to create HTML from scratch and convert to ACF
- **Visual First**: Start with actual block editor patterns
- **Flexible**: Full WordPress block editor functionality
- **Maintainable**: Uses standard WordPress block development patterns
- **CSS Control**: Any layout conflicts can be resolved with additional CSS if needed

**Block Spacing Architecture:**
- **No Horizontal Margins/Padding**: Blocks should NOT include left/right margins or padding
- **Layout Container Handles Spacing**: The `max-w-8xl mx-auto px-4 md:px-6 lg:px-8` container in `resources/views/layouts/app.blade.php:47` provides consistent horizontal spacing for all content
- **Internal Column Spacing Only**: Blocks only need internal spacing when they contain columns or multi-column layouts
- **Vertical Spacing**: Blocks can include top/bottom margins and padding as needed for visual hierarchy
- **Consistency**: This approach ensures all blocks align perfectly with the boxed layout without conflicting spacing

**Block Registration:**
Native blocks are automatically registered using the Sage Native Block package's registration system in `app/setup.php`:

```php
/**
 * Register block types using block.json metadata from the theme's blocks directory.
 * This function will scan the 'resources/js/blocks' directory for block.json files.
 */
add_action('init', function () {
    $blocks_dir = get_template_directory() . '/resources/js/blocks';
    if (!is_dir($blocks_dir)) {
        return;
    }

    $block_folders = scandir($blocks_dir);

    foreach ($block_folders as $folder) {
        if ($folder === '.' || $folder === '..') {
            continue;
        }

        $block_json_path = $blocks_dir . '/' . $folder . '/block.json';

        if (file_exists($block_json_path)) {
            register_block_type($block_json_path);
        }
    }
}, 10);
```

This automatically discovers and registers all blocks in `resources/js/blocks/` based on their `block.json` metadata files. Blocks are compiled through Vite and fully editable in the browser like WordPress native blocks.

**Dynamic Content Handling:**
For blocks requiring dynamic content (like article grids), use the view.js approach:
- **save.jsx**: Outputs static HTML with data attributes
- **view.js**: Reads attributes and loads dynamic content via WordPress REST API
- **No PHP render callback needed**: All dynamic functionality handled client-side

**Native Block Development Workflow:**
Since native blocks are JS/React/CSS based and don't use PHP rendering, the development process is streamlined:

1. **Development**: Edit files in `resources/js/blocks/[block-name]/`
2. **Build**: Run `npm run build` to compile changes
3. **No cache clearing needed**: Native blocks don't use WordPress PHP caches
4. **Immediate refresh**: Changes appear immediately after build - just refresh the editor/frontend

**Key Differences from ACF Blocks:**
- **No `wp acorn` commands needed**: Native blocks don't use Blade templates or PHP rendering
- **No view cache**: No `wp acorn view:clear` or `wp acorn optimize:clear` required
- **Faster development**: Edit → Build → Refresh workflow
- **Client-side rendering**: Dynamic content loaded via JavaScript and REST API

### Asset Loading
Assets are loaded through Laravel's Vite integration, with manifest-based dependency management for optimal performance.

### WordPress Features
- Navigation menus registered (primary_navigation)
- Standard WordPress theme supports enabled (post-thumbnails, html5, etc.)
- Two widget areas: sidebar-primary and sidebar-footer
- Core block patterns disabled in favor of custom implementation

## Components vs Composers vs Partials

### When to Use What:
- **Partials** (`@include`): Simple, static template pieces
- **Composers**: Data logic for templates (preferred over inline PHP)
- **Components**: Reusable UI elements with both data and template logic

### Component Creation
```bash
wp acorn make:component AlertBox    # Creates app/View/Components/AlertBox.php + template
```

**Component Usage:**
```blade
<x-alert-box type="warning" :dismissible="true" class="mb-4">
  Important message here
</x-alert-box>
```

**Component Data Flow:**
- Constructor arguments become template variables
- Use `camelCase` in PHP, `kebab-case` in HTML attributes
- Prefix with `:` to pass PHP expressions: `:user="$currentUser"`

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

### Boxed Layout Implementation
The theme uses a **template-level container** approach for consistent boxed layout across desktop, tablet, and mobile:

- **Container**: `max-w-8xl mx-auto px-4 md:px-6 lg:px-8` wrapper around main content and sidebar (1440px max-width)
- **Shared constraints**: Both main content and sidebar inherit same max-width and alignment
- **Responsive spacing**: Mobile (px-4), tablet (px-6), desktop (px-8) horizontal padding
- **Sidebar consistency**: Maintains alignment with main content when present
- **Location**: Applied at layout level in `resources/views/layouts/app.blade.php:47`
- **Custom utility**: Uses custom `max-w-8xl` class defined in `resources/css/app.css:179-181`

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