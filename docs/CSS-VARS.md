# CSS Variables Reference

This document catalogs all available CSS variables in the Thyra theme, their sources, and usage patterns for blocks, Blade views, and components.

## Table of Contents

- [Variable Sources](#variable-sources)
- [Custom Editorial Variables](#custom-editorial-variables)
  - [Typography Scale](#typography-scale)
  - [Font Families](#font-families)
  - [Editorial Color Palette](#editorial-color-palette)
  - [Line Heights & Spacing](#line-heights--spacing)
  - [Layout & Design System Variables](#layout--design-system-variables)
- [WordPress Preset Variables](#wordpress-preset-variables)
  - [Color Variables (260 total)](#color-variables-260-total)
  - [Typography Presets](#typography-presets)
    - [Font Family Variables (6 total)](#font-family-variables-6-total)
    - [Font Size Variables (13 total)](#font-size-variables-13-total)
  - [Other WordPress Presets](#other-wordpress-presets)
- [Complete Font Size Reference](#complete-font-size-reference)
  - [Custom Editorial Font Sizes (5 total)](#custom-editorial-font-sizes-5-total)
  - [Tailwind Generated Font Sizes (13 total)](#tailwind-generated-font-sizes-13-total)
- [Usage Patterns](#usage-patterns)
  - [1. Block Development (Native Blocks)](#1-block-development-native-blocks)
  - [2. Blade Templates](#2-blade-templates)
  - [3. Component Development](#3-component-development)
  - [4. Editor Integration](#4-editor-integration)
- [Configuration Sources](#configuration-sources)
  - [Vite Configuration](#vite-configuration)
  - [Theme.json Integration](#themejson-integration)
- [Best Practices](#best-practices)
  - [1. Variable Naming Convention](#1-variable-naming-convention)
  - [2. Responsive Design](#2-responsive-design)
  - [3. Block Development](#3-block-development)
  - [4. Performance Considerations](#4-performance-considerations)

## Variable Sources

The theme generates **330+ CSS variables** from multiple sources:
- **Custom Editorial Variables**: Defined in `resources/css/app.css` (20+ variables)
- **WordPress Preset Variables**: Generated from `theme.json` via Vite plugin (319 total variables)
  - 260 color variables (Tailwind color palette + custom editorial colors)
  - 13 font size variables (Tailwind scale)
  - 6 font family variables
  - 40+ other presets (spacing, shadows, gradients, aspect ratios)
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

Generated automatically from `theme.json` via `wordpressThemeJson()` Vite plugin with 319 total variables:

### Color Variables (260 total)
```css
/* Tailwind Color Palette (248 variables) - Complete color spectrum */
--wp--preset--color--red-50: oklch(97.1% .013 17.38);
--wp--preset--color--red-100: oklch(93.6% .032 17.717);
--wp--preset--color--red-500: oklch(63.7% .237 25.331);
--wp--preset--color--red-900: oklch(39.6% .141 25.723);
/* ... continues for all colors: orange, amber, yellow, lime, green, emerald,
     teal, cyan, sky, blue, indigo, violet, purple, fuchsia, pink, rose,
     slate, gray, zinc, neutral, stone (each with 50-950 variants) */

/* Custom Editorial Colors (6 variables) */
--wp--preset--color--black: #000;
--wp--preset--color--white: #fff;
--wp--preset--color--charcoal: #333;
--wp--preset--color--gray: #666;
--wp--preset--color--light-gray: #999;
--wp--preset--color--off-white: #fafafa;
```

### Typography Presets

#### Font Family Variables (6 total)
```css
/* WordPress font family presets */
--wp--preset--font-family--sans: ui-sans-serif,system-ui,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;
--wp--preset--font-family--serif: ui-serif,Georgia,Cambria,Times New Roman,Times,serif;
--wp--preset--font-family--mono: ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,Liberation Mono,Courier New,monospace;
--wp--preset--font-family--lato: Lato,system-ui,sans-serif;
--wp--preset--font-family--bitter: Bitter,serif;
--wp--preset--font-family--menlo: Menlo,ui-monospace,SFMono-Regular,Monaco,Consolas,Liberation Mono,Courier New,monospace;
```

#### Font Size Variables (13 total)
```css
/* Tailwind font size scale - Complete responsive typography system */
--wp--preset--font-size--xs: .75rem;      /* 12px */
--wp--preset--font-size--sm: .875rem;     /* 14px */
--wp--preset--font-size--base: 1rem;      /* 16px */
--wp--preset--font-size--lg: 1.125rem;    /* 18px */
--wp--preset--font-size--xl: 1.25rem;     /* 20px */
--wp--preset--font-size--2xl: 1.5rem;     /* 24px */
--wp--preset--font-size--3xl: 1.875rem;   /* 30px */
--wp--preset--font-size--4xl: 2.25rem;    /* 36px */
--wp--preset--font-size--5xl: 3rem;       /* 48px */
--wp--preset--font-size--6xl: 3.75rem;    /* 60px */
--wp--preset--font-size--7xl: 4.5rem;     /* 72px */
--wp--preset--font-size--8xl: 6rem;       /* 96px */
--wp--preset--font-size--9xl: 8rem;       /* 128px */
```

### Other WordPress Presets
```css
/* Spacing presets (40+ variables) - Full Tailwind spacing scale */
--wp--preset--spacing--10: 0.25rem;       /* 4px */
--wp--preset--spacing--20: 0.5rem;        /* 8px */
--wp--preset--spacing--30: 0.75rem;       /* 12px */
--wp--preset--spacing--40: 1rem;          /* 16px */
/* ... continues through full Tailwind scale to --wp--preset--spacing--96 */

/* Aspect ratio presets */
--wp--preset--aspect-ratio--square: 1;
--wp--preset--aspect-ratio--4-3: 4/3;
--wp--preset--aspect-ratio--16-9: 16/9;

/* Shadow presets */
--wp--preset--shadow--natural: 0 8px 16px rgba(0, 0, 0, 0.15);
--wp--preset--shadow--deep: 0 12px 24px rgba(0, 0, 0, 0.25);

/* Gradient presets */
--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg, rgba(6,147,227,1) 0%, rgb(155,81,224) 100%);
```

## Complete Font Size Reference

The theme provides **18 total font size variables** from two sources, offering comprehensive typography control for all design needs.

### Custom Editorial Font Sizes (5 total)
These are custom sizes specific to editorial design, defined in `resources/css/app.css`:

```css
/* Editorial Typography - Custom sizes not in Tailwind */
--font-size-hero: 55px;            /* Hero post titles (desktop) */
--font-size-hero-mobile: 28px;     /* Hero post titles (mobile) */
--font-size-title: 30px;           /* Large editorial headlines (desktop) */
--font-size-title-mobile: 20px;    /* Large editorial headlines (mobile) */
--font-size-small: 14px;           /* Meta text - article-grid-block compatibility */
```

**Usage:** Primarily in custom blocks and editorial templates where specific design requirements need precise control.

### Tailwind Generated Font Sizes (13 total)
WordPress preset variables generated from Tailwind's font size scale via `wordpressThemeJson()`:

```css
/* Complete Tailwind Font Scale */
--wp--preset--font-size--xs: .75rem;      /* 12px - Small captions, labels */
--wp--preset--font-size--sm: .875rem;     /* 14px - Meta text, small body */
--wp--preset--font-size--base: 1rem;      /* 16px - Standard body text */
--wp--preset--font-size--lg: 1.125rem;    /* 18px - Large body text */
--wp--preset--font-size--xl: 1.25rem;     /* 20px - Small headings */
--wp--preset--font-size--2xl: 1.5rem;     /* 24px - Medium headings */
--wp--preset--font-size--3xl: 1.875rem;   /* 30px - Large headings */
--wp--preset--font-size--4xl: 2.25rem;    /* 36px - Extra large headings */
--wp--preset--font-size--5xl: 3rem;       /* 48px - Hero headlines */
--wp--preset--font-size--6xl: 3.75rem;    /* 60px - Display headlines */
--wp--preset--font-size--7xl: 4.5rem;     /* 72px - Large displays */
--wp--preset--font-size--8xl: 6rem;       /* 96px - Extra large displays */
--wp--preset--font-size--9xl: 8rem;       /* 128px - Massive displays */
```

**Usage:** Available in WordPress block editor font size picker and for consistent design system scaling.

### Font Size Usage Patterns

**In Block Editor (WordPress Classes):**
```blade
{{-- WordPress preset classes --}}
<div class="has-sm-font-size">Small text using Tailwind xs (14px)</div>
<div class="has-base-font-size">Body text using Tailwind base (16px)</div>
<div class="has-2xl-font-size">Heading using Tailwind 2xl (24px)</div>
<div class="has-5xl-font-size">Hero using Tailwind 5xl (48px)</div>
```

**In Custom CSS/Blocks:**
```css
/* Editorial custom sizes */
.hero-headline {
  font-size: var(--font-size-hero);        /* 55px desktop */
}

@media (max-width: 768px) {
  .hero-headline {
    font-size: var(--font-size-hero-mobile); /* 28px mobile */
  }
}

/* Tailwind preset sizes */
.article-title {
  font-size: var(--wp--preset--font-size--3xl); /* 30px */
}

.meta-text {
  font-size: var(--wp--preset--font-size--sm);  /* 14px */
}
```

**Size Comparison Chart:**
```
 12px  --wp--preset--font-size--xs
 14px  --wp--preset--font-size--sm  ≈ --font-size-small
 16px  --wp--preset--font-size--base
 18px  --wp--preset--font-size--lg
 20px  --wp--preset--font-size--xl   ≈ --font-size-title-mobile
 24px  --wp--preset--font-size--2xl
 28px  --font-size-hero-mobile
 30px  --wp--preset--font-size--3xl  ≈ --font-size-title
 36px  --wp--preset--font-size--4xl
 48px  --wp--preset--font-size--5xl
 55px  --font-size-hero
 60px  --wp--preset--font-size--6xl
 72px  --wp--preset--font-size--7xl
 96px  --wp--preset--font-size--8xl
128px  --wp--preset--font-size--9xl
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