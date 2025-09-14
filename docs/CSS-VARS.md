# CSS Variables Reference

This document catalogs all available CSS variables in the Thyra theme, their sources, and usage patterns for blocks, Blade views, and components.

## Variable Sources

The theme generates **300+ CSS variables** from multiple sources:
- **Custom Editorial Variables**: Defined in `resources/css/app.css`
- **WordPress Preset Variables**: Generated from `theme.json` via Vite plugin (248 colors + 68 other presets)
- **Tailwind Integration**: Via `@tailwindcss/vite` plugin and `wordpressThemeJson()` configuration

## Custom Editorial Variables

### Typography Scale
```css
/* Editorial Typography - Custom sizes not in Tailwind */
--font-size-hero: 55px;            /* Hero post titles (desktop) */
--font-size-hero-mobile: 28px;     /* Hero post titles (mobile) */
--font-size-title: 30px;           /* Large editorial headlines (desktop) */
--font-size-title-mobile: 20px;    /* Large editorial headlines (mobile) */
--font-size-small: 14px;           /* Meta text - article-grid-block compatibility */
```

**Usage in Blocks:**
```jsx
// Article Grid Block - resources/js/blocks/article-grid-block/editor.jsx:214
<h2 className={`wp-block-heading has-${headingFontFamily}-font-family article-grid-font-${headingFontSize}`}>

// CSS implementation - resources/js/blocks/article-grid-block/style.css:61-79
.article-grid-font-small {
  font-size: var(--font-size-small) !important; /* 14px */
}
.article-grid-font-medium {
  font-size: var(--font-size-medium) !important; /* 16px */
}
```

### Font Families
```css
/* Individual font family definitions for WordPress theme.json */
--font-lato: "Lato", system-ui, sans-serif;
--font-bitter: "Bitter", serif;
--font-menlo: "Menlo", ui-monospace, SFMono-Regular, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
```

**Usage in Blade Views:**
```blade
{{-- Apply font families using WordPress block editor classes --}}
<div class="has-lato-font-family">Sans serif content</div>
<div class="has-bitter-font-family">Serif headings</div>
<div class="has-menlo-font-family">Code blocks</div>
```

### Editorial Color Palette
```css
/* Thaiconomics Editorial Palette */
--color-black: #000000;
--color-charcoal: #333333;
--color-gray: #666666;
--color-light-gray: #999999;
--color-white: #ffffff;
--color-off-white: #fafafa;

/* Extended grays for UI elements */
--color-gray-50: #f9fafb;
--color-gray-100: #f3f4f6;
--color-gray-200: #e5e7eb;
--color-gray-300: #d1d5db;
--color-gray-400: #9ca3af;
--color-gray-500: #6b7280;
--color-gray-600: #4b5563;
--color-gray-700: #374151;
--color-gray-800: #1f2937;
--color-gray-900: #111827;
```

### Line Heights & Spacing
```css
/* Line Heights for Editorial Design */
--line-height-tight: 1.2;      /* Headlines - tighter than Tailwind's leading-tight (1.25) */
--line-height-normal: 1.6;     /* Body text - looser than Tailwind's leading-normal (1.5) */
--line-height-relaxed: 1.8;    /* Large body text - looser than Tailwind's leading-relaxed (1.625) */

/* Custom Editorial Spacing */
--spacing-section: 4rem;        /* Between major sections */
--spacing-article: 2rem;        /* Between articles */
--spacing-content: 1.5rem;      /* Content spacing */
```

### Layout & Design System Variables
```css
/* Content width constraints */
--content-width-narrow: 65ch;   /* Optimal reading line length */
--content-width-medium: 80ch;   /* Medium content blocks */
--content-width-wide: 1200px;   /* Full-width sections */

/* Editorial layout proportions */
--hero-aspect-ratio: 16/9;      /* Hero image aspect ratio */
--thumbnail-aspect-ratio: 4/3;  /* Article thumbnail aspect ratio */
--sidebar-width: 320px;         /* Sidebar width */

/* Animation durations */
--transition-fast: 0.15s;
--transition-normal: 0.3s;
--transition-slow: 0.5s;

/* Focus ring for accessibility */
--focus-ring: 0 0 0 2px var(--color-black);

/* Z-index Scale */
--z-index-dropdown: 10;
--z-index-modal: 50;
--z-index-popover: 100;
--z-index-tooltip: 200;
```

## WordPress Preset Variables

Generated automatically from `theme.json` via `wordpressThemeJson()` Vite plugin with 316 total variables:

### Color Variables (248 total)
```css
/* WordPress color presets - examples */
--wp--preset--color--black: #000000;
--wp--preset--color--white: #ffffff;
--wp--preset--color--gray-50: #f9fafb;
--wp--preset--color--gray-100: #f3f4f6;
/* ... continues for all Tailwind colors */
```

### Typography Presets (68 total)
```css
/* Font family presets */
--wp--preset--font-family--lato: "Lato", system-ui, sans-serif;
--wp--preset--font-family--bitter: "Bitter", serif;
--wp--preset--font-family--menlo: "Menlo", ui-monospace;

/* Font size presets */
--wp--preset--font-size--small: 14px;
--wp--preset--font-size--medium: 16px;
--wp--preset--font-size--large: 24px;
--wp--preset--font-size--x-large: 30px;
--wp--preset--font-size--xx-large: 55px;

/* Spacing presets */
--wp--preset--spacing--10: 0.25rem;
--wp--preset--spacing--20: 0.5rem;
--wp--preset--spacing--30: 0.75rem;
/* ... continues for Tailwind spacing scale */

/* Other presets */
--wp--preset--aspect-ratio--square: 1;
--wp--preset--aspect-ratio--4-3: 4/3;
--wp--preset--aspect-ratio--16-9: 16/9;

--wp--preset--shadow--natural: 0 8px 16px rgba(0, 0, 0, 0.15);
--wp--preset--shadow--deep: 0 12px 24px rgba(0, 0, 0, 0.25);

--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg, rgba(6,147,227,1) 0%, rgb(155,81,224) 100%);
```

## Usage Patterns

### 1. Block Development (Native Blocks)

**CSS Classes with Variables:**
```css
/* resources/js/blocks/article-grid-block/style.css */
.article-grid-font-small {
  font-size: var(--font-size-small) !important;
}

.article-grid-font-x-large {
  font-size: var(--font-size-title) !important; /* 30px desktop */
}

/* Responsive usage */
@media (max-width: 768px) {
  .article-grid-font-x-large {
    font-size: var(--font-size-title-mobile) !important; /* 20px mobile */
  }
}
```

**JSX Implementation:**
```jsx
// Dynamic class application
<h2 className={`wp-block-heading has-${headingFontFamily}-font-family article-grid-font-${headingFontSize}`}>
  {post.title?.rendered || ''}
</h2>

// CSS custom properties in inline styles
<div style={{
  color: 'var(--color-gray)',
  marginTop: 'var(--spacing-content)'
}}>
```

### 2. Blade Templates

**WordPress Block Editor Classes:**
```blade
{{-- Font families --}}
<div class="has-lato-font-family">Sans serif text</div>
<div class="has-bitter-font-family">Serif headlines</div>

{{-- WordPress preset classes --}}
<div class="has-black-color has-white-background-color">
  High contrast content
</div>

{{-- Custom CSS classes using variables --}}
<article class="text-hero">Hero headline</article>
<p class="text-meta">Meta information</p>
```

**Direct Variable Usage:**
```blade
<section style="
  max-width: var(--content-width-wide);
  margin: var(--spacing-section) auto;
  padding: 0 var(--spacing-content);
">
  <div class="content-narrow">
    {{-- Content uses CSS utility class --}}
  </div>
</section>
```

### 3. Component Development

**CSS Utility Classes:**
```css
/* resources/css/app.css - Editorial Typography Utilities */
.text-hero {
  font-size: var(--font-size-hero);
  line-height: var(--line-height-tight);
  font-weight: 700;
}

.text-title {
  font-size: var(--font-size-title);
  line-height: var(--line-height-tight);
  font-weight: 600;
}

.text-meta {
  font-size: var(--font-size-small);
  color: var(--color-gray);
  font-weight: 400;
}
```

**Layout Utilities:**
```css
.content-narrow { max-width: var(--content-width-narrow); }
.content-medium { max-width: var(--content-width-medium); }
.content-wide { max-width: var(--content-width-wide); }

.aspect-hero { aspect-ratio: var(--hero-aspect-ratio); }
.aspect-thumbnail { aspect-ratio: var(--thumbnail-aspect-ratio); }
```

### 4. Editor Integration

**Matching Variables Across Files:**
```css
/* resources/css/app.css */
--font-size-hero: 55px;

/* resources/css/editor.css - Mirror for WYSIWYG */
--font-size-hero: 55px;
```

## Configuration Sources

### Vite Configuration
```javascript
// vite.config.js - WordPress theme.json generation
wordpressThemeJson({
  disableTailwindColors: false,    // Generates 248 color variables
  disableTailwindFonts: false,     // Generates font family variables
  disableTailwindFontSizes: false, // Generates font size variables
})
```

### Theme.json Integration
The `wordpressThemeJson()` plugin automatically:
- Converts Tailwind config to WordPress theme.json format
- Generates CSS variables for all Tailwind design tokens
- Creates block editor compatible preset classes
- Provides `--wp--preset--*` variables for all design tokens

## Best Practices

### 1. Variable Naming Convention
- **Custom editorial**: `--font-size-hero`, `--color-charcoal`
- **WordPress presets**: `--wp--preset--color--black`, `--wp--preset--font-size--large`
- **CSS classes**: `article-grid-font-small`, `has-lato-font-family`

### 2. Responsive Design
```css
/* Mobile-first approach with custom variables */
.text-hero {
  font-size: var(--font-size-hero-mobile);
}

@media (min-width: 768px) {
  .text-hero {
    font-size: var(--font-size-hero);
  }
}
```

### 3. Block Development
- Use `!important` for block-specific typography overrides
- Create semantic class names that reference variables
- Provide responsive variants for mobile/desktop scaling
- Mirror editor.css variables for WYSIWYG accuracy

### 4. Performance Considerations
- Variables are computed once at root level
- Prefer CSS custom properties over inline styles for dynamic values
- Use CSS classes for repeated patterns rather than inline variable references
- WordPress preset variables are automatically optimized by the theme.json system