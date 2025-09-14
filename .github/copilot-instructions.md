## GitHub Copilot Instructions

This repository is a Sage WordPress theme built on Laravel's Acorn framework. Please follow these guidelines when using GitHub Copilot in this project:

### Architecture & Conventions
- The repository includes the official Roots Sage documentation in `docs/roots-docs/sage/`. Always consult these files for best practices, Blade template usage, block development, and Sage conventions.
- Use **Laravel Blade templates** for views (`resources/views/*.blade.php`) - NOT traditional PHP templates.
- All PHP classes use the `App\` namespace and follow PSR-4 autoloading (see `composer.json`).
- Service Providers are in `app/Providers/` and should extend Sage's base provider.
- **View Composers** in `app/View/Composers/` are the cornerstone of Sage architecture - they separate data logic from presentation and enable clean, maintainable templates. Always prefer Composers over inline PHP logic.
- **Automatic View Binding**: Sage auto-matches Composers to views based on file paths (convert `kebab-case` view names to `PascalCase` Composer names).
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
- Use WP-CLI for image size testing: `wp media regenerate --all` and `wp eval "print_r(get_intermediate_image_sizes());"`.

### Blade Template & Component Management
```bash
wp acorn view:cache              # Compile all Blade templates (debugging)
wp acorn view:clear              # Clear compiled Blade templates
wp acorn optimize:clear          # Clear all caches (views, config, routes)
wp acorn make:composer Name      # Create new View Composer
wp acorn make:component Name     # Create new Blade Component
```

### Site Comparison Tool
The theme includes a Playwright script (`compare-sites.js`) for comparing the local development site with the reference design:
- **Screenshots**: Captures full-page screenshots of both sites
- **Structure Analysis**: Extracts navigation, sections, headings, and CSS classes
- **Difference Detection**: Highlights key layout and content differences
- **Reports**: Generates JSON structure reports and HTML content exports
- **Files Generated**: `online-version.png`, `local-version.png`, `*-structure.json`, `*-content.html`

This tool is essential for ensuring design consistency and identifying layout issues during development.

### Local Development SSL & Font Loading
For local development using Laravel Valet or similar tools, the local site uses self-signed SSL certificates. When testing with curl:
```bash
curl -i http://thyra.test   # Use HTTP instead of HTTPS for local development
curl -i -k https://thyra.test # Or use -k flag to ignore SSL certificate errors
```

**Font Loading Issues**: Chrome errors like `Failed to decode downloaded font` or `OTS parsing error: invalid sfntVersion` are typically caused by nginx MIME type misconfiguration. Laravel Valet/nginx may not serve WOFF2 files with the correct `font/woff2` MIME type.

**Solution**: Configure nginx to serve WOFF2 with proper MIME type:
```nginx
location ~* \.(woff2)$ {
    add_header Content-Type font/woff2;
    expires 1y;
    add_header Cache-Control "public, immutable";
}
```

### WordPress Integration
- Theme setup and WordPress hooks are in `app/setup.php` and `app/filters.php`.
- Navigation menus, theme supports, and widget areas are registered in setup files.
- Block editor integration and asset loading are managed via Vite and custom filters.
- Full-site editing is disabled; use custom block patterns if needed.
- **CSS Variables**: Theme generates 316 total CSS variables (248 colors from `theme.json` + 68 WordPress presets) using `--wp--preset--*` format.

### Block Development Strategy
The theme uses **Native Blocks as the PRIMARY approach** for all block development, providing maximum flexibility and modern development patterns.

#### Native Blocks (PRIMARY APPROACH)
For all blocks - flexible, customer-editable, and dynamic content blocks:
- **Package**: `composer require imagewize/sage-native-block --dev`
- **Recommended Workflow**:
  1. **Create Pattern in Editor**: Build the desired layout using WordPress block editor
  2. **Copy to Claude**: Provide the pattern HTML/structure as reference
  3. **Generate Native Block**: Use `wp acorn sage-native-block:add-setup imagewize/my-cool-block`
  4. **Adapt with Claude**: Let Claude convert the pattern into native block structure
- **Benefits**:
  - No time wasted creating HTML from scratch
  - No manual conversion to ACF Composer block code
  - Visual-first development using editor patterns as base
  - Full WordPress block editor functionality
  - CSS Control: Any layout conflicts can be resolved with additional CSS
- **Block Spacing Convention**:
  - **NO horizontal margins/padding**: Blocks should never include left/right spacing
  - **Layout container provides spacing**: The boxed layout (`max-w-8xl mx-auto px-4 md:px-6 lg:px-8`) in `resources/views/layouts/app.blade.php:47` handles all horizontal spacing
  - **Internal column spacing only**: Only add internal spacing for multi-column layouts within blocks
  - **Vertical spacing allowed**: Blocks can include top/bottom margins/padding for visual hierarchy
- **Location**: `resources/js/blocks/`
- **Registration**: Blocks are automatically registered via the Sage Native Block package's registration system in `app/setup.php`, which scans for `block.json` files and calls `register_block_type()` on each
- **Characteristics**: JS/React based, fully editable in browser, compiled through Vite
- **Dynamic Content**: For blocks requiring dynamic content (like article grids), use view.js with WordPress REST API

#### Native Block Development Workflow
Since native blocks are JS/React/CSS based and compiled through Vite, they have a streamlined development process:

**Development Process:**
1. **Edit**: Modify files in `resources/js/blocks/[block-name]/` (editor.jsx, save.jsx, view.js, style.css, block.json)
2. **Build**: Run `npm run build` to compile changes through Vite
3. **Refresh**: Changes appear immediately in editor/frontend - no cache clearing needed

**Key Advantages:**
- **No `wp acorn` commands needed**: Native blocks don't use PHP rendering or Blade templates
- **No cache clearing**: WordPress PHP caches (views, routes, config) don't affect native blocks
- **Faster iteration**: Edit → Build → Refresh workflow (vs. Edit → Clear Cache → Refresh)
- **Client-side rendering**: All dynamic content handled via JavaScript and REST API
- **Immediate feedback**: Block changes visible instantly after compilation

**When Cache Clearing IS Needed:**
- **Never for native blocks**: They're pure JS/CSS and don't use WordPress PHP caching
- **Only for ACF blocks**: Which use Blade templates and PHP rendering
- **Theme changes**: When modifying `app/setup.php`, View Composers, or other PHP files

#### ACF Blocks (USE ONLY WHEN ABSOLUTELY NECESSARY)
For exceptional cases where native blocks cannot meet requirements:
- **Package**: `composer require log1x/acf-composer`
- **Use Cases**: 
  - Extremely rigid, admin-only control over content structure
  - Complex server-side rendering requirements that cannot be handled client-side
  - Legacy compatibility requirements
- **Commands**: 
  - `wp acorn make:block BlockName` - Creates app/Blocks/BlockName.php
  - `wp acorn make:field BlockName` - Creates app/Fields/BlockName.php (optional)
- **Template Location**: `resources/views/blocks/`
- **Note**: Should only be used when native blocks are insufficient

### Font Management
Sage provides a structured workflow for adding custom fonts:

1. **Add font files** to `resources/fonts/` directory (use `.woff2` format for best browser support)
2. **Create `resources/css/fonts.css`** file for `@font-face` declarations
3. **Import fonts.css** in both `app.css` and `editor.css`: `@import './fonts.css';`
4. **Add to Tailwind theme** in `app.css`: `@theme { --font-primary: "Font Name", sans-serif; }`

**Current Font Stack:**
- **Sans Serif**: Lato Regular (400) for body text and UI elements
- **Serif**: Bitter Regular (400) for headings, intros, and editorial content  
- **Monospace**: Menlo Regular (400) for code and technical content

**Font CSS Structure:**
```css
/* Lato - Primary Sans Serif Font */
@font-face {
  font-display: swap;
  font-family: 'Lato';
  font-style: normal;
  font-weight: 400;
  src: url('@fonts/lato-regular.woff2') format('woff2');
}

/* Bitter - Display Font (Regular) */
@font-face {
  font-display: swap;
  font-family: 'Bitter';
  font-style: normal;
  font-weight: 400;
  src: url('@fonts/bitter-regular.woff2') format('woff2');
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

**Resources:**
- Use [Google Webfonts Helper](https://gwfh.mranftl.com/) for downloading fonts and generating CSS
- **API Downloads**: Use the API for bulk downloads: `https://gwfh.mranftl.com/api/fonts/{font-name}?download=zip&subsets=latin&variants=regular,300,700,900&formats=woff2`
  - Example: `https://gwfh.mranftl.com/api/fonts/lato?download=zip&subsets=latin&variants=300,700,900,regular,italic&formats=woff2`
- Always use `font-display: swap` for better loading performance

### Best Practices
- **Views**: Use Blade templates (`.blade.php`) instead of traditional PHP templates.
- **Data Logic**: Use View Composers in `app/View/Composers/` instead of inline `@php` blocks in templates.
- **Architecture**: Follow Laravel patterns - Service Providers, View Composers, dependency injection.
- **Assets**: Reference assets using Vite's manifest system for optimal performance.
- **Fonts**: Use the Sage font workflow with `.woff2` files in `resources/fonts/` and `fonts.css` for declarations.
- **Code Style**: Follow PSR-12 standards and use `./vendor/bin/pint` for formatting.

### Components vs Composers vs Partials

**When to Use What:**
- **Partials** (`@include`): Simple, static template pieces
- **Composers**: Data logic for templates (preferred over inline PHP)
- **Components**: Reusable UI elements with both data and template logic

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

### View Composers Usage
View Composers are the cornerstone of Sage architecture and the proper way to pass data to Blade templates:

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
- **Separation of Concerns**: Keep data fetching logic out of Blade templates
- **Reusability**: Share data logic across multiple templates
- **Testability**: Easier to unit test data logic separately
- **Performance**: Centralized data fetching and caching
- **Laravel Patterns**: Follow established Laravel/Sage architectural patterns
- **Cleaner Templates**: Blade files focus purely on presentation

**Automatic View Binding:**
- View: `/resources/views/partials/hero-section.blade.php`
- Composer: `/app/View/Composers/HeroSection.php` 
- Auto-matched via file path conversion (kebab-case → PascalCase)

**`with()` vs `override()` Methods:**
- **`with()`**: Adds data without overriding inherited/passed data (use this)
- **`override()`**: Replaces existing data with the same key names

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

**Boxed Layout**: The theme uses a template-level container (`max-w-8xl mx-auto px-4 md:px-6 lg:px-8`) around main content and sidebar for consistent responsive boxed layout across all screen sizes (1440px max-width). The `max-w-8xl` is a custom utility class defined in `resources/css/app.css`.

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
