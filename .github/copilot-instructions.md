## GitHub Copilot Instructions

This repository is a Sage WordPress theme built on Laravel's Acorn framework. Please follow these guidelines when using GitHub Copilot in this project:

### Architecture & Conventions
- Use **Laravel Blade templates** for views (`resources/views/*.blade.php`) - NOT traditional PHP templates.
- All PHP classes use the `App\` namespace and follow PSR-4 autoloading (see `composer.json`).
- Service Providers are in `app/Providers/` and should extend Sage's base provider.
- **View Composers** in `app/View/Composers/` pass data to Blade templates - use these instead of inline PHP logic.
- Asset compilation is handled by **Vite** (see `vite.config.js`), with source files in `resources/` and output in `public/build/`.
- **Tailwind CSS** is used for styling. Use utility classes in Blade templates and CSS files.

### App Directory Structure
The `app/` directory contains all theme functionality and is namespaced under `App\`:

- `app/setup.php` — Theme setup: enqueue assets, register theme features, navigation menus, sidebars
- `app/filters.php` — WordPress filters (e.g., excerpt_more filter)
- `app/Providers/` — Service Providers for theme functionality
- `app/View/Composers/` — View Composers for passing data to Blade templates (preferred over inline PHP)

### Development Workflow
- Use `npm run dev` for frontend development (Vite hot reload).
- Use `npm run build` for production asset builds.
- Use `./vendor/bin/pint` for PHP code formatting.
- Use translation commands (`npm run translate:*`) for internationalization.
- Use `node compare-sites.js` to run Playwright comparison between thyra.test and reference site (clarity-tailwind.preview.uideck.com).

### Site Comparison Tool
The theme includes a Playwright script (`compare-sites.js`) for comparing the local development site with the reference design:
- **Screenshots**: Captures full-page screenshots of both sites
- **Structure Analysis**: Extracts navigation, sections, headings, and CSS classes
- **Difference Detection**: Highlights key layout and content differences
- **Reports**: Generates JSON structure reports and HTML content exports
- **Files Generated**: `online-version.png`, `local-version.png`, `*-structure.json`, `*-content.html`

This tool is essential for ensuring design consistency and identifying layout issues during development.

### Local Development SSL
For local development using Laravel Valet or similar tools, the local site uses self-signed SSL certificates. When testing with curl:
```bash
curl -i http://thyra.test   # Use HTTP instead of HTTPS for local development
curl -i -k https://thyra.test # Or use -k flag to ignore SSL certificate errors
```

### WordPress Integration
- Theme setup and WordPress hooks are in `app/setup.php` and `app/filters.php`.
- Navigation menus, theme supports, and widget areas are registered in setup files.
- Block editor integration and asset loading are managed via Vite and custom filters.
- Full-site editing is disabled; use custom block patterns if needed.

### Block Development Strategy
The theme uses two distinct approaches for block development:

#### ACF Blocks (Rigid, Admin-Controlled)
For editorial components that customers should not customize extensively:
- **Package**: `composer require log1x/acf-composer`
- **Purpose**: Rigid editorial components (hero sections, featured articles)
- **Commands**: 
  - `wp acorn make:block BlockName` - Creates app/Blocks/BlockName.php
  - `wp acorn make:field BlockName` - Creates app/Fields/BlockName.php (optional)
- **Template Location**: `resources/views/blocks/`
- **Characteristics**: Limited customization, admin-defined content

#### Native Blocks (Flexible, Customer-Editable) 
For blocks that should be fully customizable like WordPress native blocks:
- **Package**: `composer require imagewize/sage-native-block --dev`
- **Purpose**: Flexible content blocks (paragraphs, headings, images, galleries)
- **Commands**: `wp acorn native-block:make BlockName`
- **Location**: `resources/js/blocks/`
- **Characteristics**: JS/React based, fully editable in browser, compiled through Vite
- **⚠️ Important Limitation**: Use only when CSS doesn't rely on flex ordering. If CSS uses `flex` with `order` properties to rearrange layouts, editor changes can conflict with styling. Use ACF Blocks for layouts with CSS flex ordering instead.

### Font Management
Sage provides a structured workflow for adding custom fonts:

1. **Add font files** to `resources/fonts/` directory (use `.woff2` format for best browser support)
2. **Create `resources/css/fonts.css`** file for `@font-face` declarations
3. **Import fonts.css** in both `app.css` and `editor.css`: `@import './fonts.css';`
4. **Add to Tailwind theme** in `app.css`: `@theme { --font-primary: "Font Name", sans-serif; }`

**Font CSS Structure:**
```css
@font-face {
  font-display: swap;
  font-family: 'Helvetica Neue';
  font-style: normal;
  font-weight: 400;
  src: url('@fonts/helvetica-neue-regular.woff2') format('woff2');
}
```

**Resources:**
- Use [google-webfonts-helper](https://google-webfonts-helper.herokuapp.com/) for downloading fonts and generating CSS
- Always use `font-display: swap` for better loading performance

### Best Practices
- **Views**: Use Blade templates (`.blade.php`) instead of traditional PHP templates.
- **Data Logic**: Use View Composers in `app/View/Composers/` instead of inline `@php` blocks in templates.
- **Architecture**: Follow Laravel patterns - Service Providers, View Composers, dependency injection.
- **Assets**: Reference assets using Vite's manifest system for optimal performance.
- **Fonts**: Use the Sage font workflow with `.woff2` files in `resources/fonts/` and `fonts.css` for declarations.
- **Code Style**: Follow PSR-12 standards and use `./vendor/bin/pint` for formatting.

### View Composers Usage
View Composers are the proper Sage way to pass data to Blade templates:

**Creating New View Composers:**
```bash
wp acorn make:composer ExampleComposer  # Creates app/View/Composers/ExampleComposer.php
```

**✅ CORRECT - Use View Composers:**
```php
// app/View/Composers/Index.php
class Index extends Composer
{
    public function with()
    {
        return [
            'featured_posts' => get_posts([
                'numberposts' => 3,
                'post_status' => 'publish',
                'meta_key' => '_thumbnail_id'
            ]),
            'categories' => get_categories(['hide_empty' => true])
        ];
    }
}
```

**❌ WRONG - Avoid inline PHP in templates:**
```php
{{-- ❌ Don't do this in Blade templates --}}
@php
  $featured_posts = get_posts(['numberposts' => 3]);
@endphp
```

**Key Benefits:**
- Separates data logic from presentation
- Reusable across multiple templates
- Easier to test and maintain
- Follows Laravel/Sage architectural patterns
- Cleaner Blade templates focused on presentation only

### Blade Layouts & Template Structure
Sage uses Laravel's Blade templating engine with layouts and includes:

**Layout Structure:**
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
  </body>
</html>
```

**Extending Layouts:**
```php
// resources/views/page.blade.php
@extends('layouts.app')

@section('header')
  @parent
  @include('partials.nav.page')
@endsection

@section('content')
  <h1>{{ $title }}</h1>
  <div>{!! $content !!}</div>
@endsection
```

**Including Partials with Data:**
```php
@include('partials.hero-section', ['featured_posts' => $featured_posts])
```

### Common Blade Template Issues & Solutions

**Critical Blade Syntax Error**: `ParseError: syntax error, unexpected token "endforeach", expecting "elseif" or "else" or "endif"`

**Root Cause**: Incorrect `@php` directive syntax that breaks the Blade compiler

- **PHP Syntax Rules**: 
  ```php
  // ❌ WRONG - causes compilation errors:
  @php($main_post = $featured_posts[0])        // Missing semicolon in single-line
  @php(
    $variable = 'value';                       // Parentheses with multi-line code
    $array = ['item1', 'item2'];
  )
  
  // ✅ CORRECT - Proper Blade @php syntax:
  @php($main_post = $featured_posts[0])        // Single-line: NO semicolon in parentheses
  @php
    $variable = 'value';                       // Multi-line: use @php/@endphp blocks
    $array = ['item1', 'item2'];
  @endphp
  ```

**Complete Fix Process**:
1. **Fix syntax**: Use `@php/@endphp` blocks for multi-line PHP, `@php($var = 'value')` for single-line (no semicolon)
2. **Clear cache**: `wp acorn view:clear` or `wp acorn optimize:clear`
3. **Force regeneration**: `rm -rf wp-content/cache/acorn/framework/views/*` if cache clearing fails
4. **Test immediately**: Use `curl -i http://thyra.test` to verify the fix
5. **Debug**: Check compiled views in `wp-content/cache/acorn/framework/views/` for syntax errors

**Important Notes**:
- Blade compilation errors persist in cache even after fixing source files
- Error messages may point to `endforeach`/`endif` but the real issue is usually malformed `@php` directives earlier in the template
- Always clear view cache after fixing Blade syntax errors

### Prerequisites
- Node.js >=20.0.0
- PHP >=8.2
- Composer

Refer to `CLAUDE.md` for a full architecture overview and workflow details.
